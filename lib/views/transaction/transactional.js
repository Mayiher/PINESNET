// transaction/transactional.js

// 1) Pestañas (idem)
document.querySelectorAll('.payment-panel .tab').forEach(tab => {
  tab.addEventListener('click', () => {
    document.querySelectorAll('.payment-panel .tab, .payment-panel .content')
      .forEach(el => el.classList.remove('active'));
    tab.classList.add('active');
    document.getElementById(tab.dataset.target).classList.add('active');
  });
});

// 2) Al enviar el pago
const form = document.getElementById('paymentForm');
form.addEventListener('submit', async e => {
  e.preventDefault();
  if (!form.checkValidity()) {
    form.reportValidity();
    return;
  }

  const d = window.paymentData;

  // 2.1) Guardar cabecera
  const salePayload = {
    id_usuario: d.id_usuario,
    fecha:      new Date().toISOString().slice(0,19).replace('T',' '),
    subtotal:   d.precioBase,
    total_iva:  Math.round(d.comision),
    descuento:  0,
    total:      Math.round(d.total)
  };

  let idVenta;
  try {
    const resp = await fetch('api/api-save-sales.php', {
      method: 'POST',
      headers: {'Content-Type':'application/json'},
      body: JSON.stringify(salePayload)
    });
    const json = await resp.json();
    if (!resp.ok) throw new Error(json.error || resp.statusText);
    idVenta = json.id_venta;
  } catch (err) {
    return alert('Error guardando venta: ' + err.message);
  }

  // 2.2) Guardar detalle
  const detailPayload = {
    id_venta:        idVenta,
    codigo_producto: d.plan,
    descripcion:     `Plan ${d.plan} (${d.vigencia} días)`,
    cantidad:        1,
    precio_unitario: d.precioBase,
    bruto:           d.precioBase,
    porcentaje_iva:  d.precioBase ? Math.round((d.comision / d.precioBase) * 100) : 0,
    iva:             Math.round(d.comision),
    total:           Math.round(d.total)
  };

  try {
    const resp2 = await fetch('api/api-save-sales-details.php', {
      method: 'POST',
      headers: {'Content-Type':'application/json'},
      body: JSON.stringify(detailPayload)
    });
    const json2 = await resp2.json();
    if (!resp2.ok) console.warn('Detalle no guardado:', json2.error);
  } catch (err) {
    console.warn('Error guardando detalle:', err);
  }

  // 2.3) Generar PDF (idem)
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF({ unit: 'pt', format: 'letter' });
  doc.setFontSize(18); doc.setTextColor('#1F375B');
  doc.text('PinesNet — Comprobante de Pago', 40, 50);

  doc.autoTable({
    startY: 80,
    head: [['Concepto','Detalle']],
    body: [
      ['Plan',                d.plan],
      ['Datos incluidos',     d.gb],
      ['Vigencia',            `${d.vigencia} días`],
      ['Precio base (COP)',   `$ ${d.precioBase.toLocaleString()}`],
      ['Comisión (COP)',      `$ ${d.comision.toFixed(2)}`],
      ['Total (COP)',         `$ ${d.total.toFixed(2)}`],
      ['ID Factura',          d.invoiceId],
      ['Fecha Compra',        d.fechaCompra],
      ['Fecha Expiración',    d.fechaExpiracion]
    ],
    theme: 'grid',
    headStyles: { fillColor: '#01ABE4' },
    styles: { cellPadding: 6, fontSize: 12 }
  });

  const h = doc.internal.pageSize.height;
  doc.setFontSize(10); doc.setTextColor('#555');
  doc.text('Gracias por su compra — PinesNet · soporte@pinesnet.com', 40, h - 40);

  window.open(doc.output('bloburl'), '_blank');
});
