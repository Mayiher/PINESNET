// transactional.js

// 1) Manejo de pestañas
document.querySelectorAll('.payment-panel .tab').forEach(tab => {
  tab.addEventListener('click', () => {
    document.querySelectorAll('.payment-panel .tab, .payment-panel .content')
            .forEach(el => el.classList.remove('active'));
    tab.classList.add('active');
    document.getElementById(tab.dataset.target).classList.add('active');
  });
});

// 2) Validación y PDF al enviar el formulario
const form = document.getElementById('paymentForm');
form.addEventListener('submit', function(e) {
  e.preventDefault();

  // 2.1) Valida todos los campos
  if (!form.checkValidity()) {
    form.reportValidity();
    return;
  }

  const data = window.paymentData;

  // 2.2) Leer y enmascarar datos de tarjeta y titular
  const cardField   = form.querySelector('input[placeholder="5136 1845 5468 3894"]');
  const rawCard     = cardField.value.replace(/\s+/g, '');
  const maskedCard  = '**** **** **** ' + rawCard.slice(-4);
  const holderField = form.querySelector('input[placeholder="NOMBRE COMPLETO"]');
  const cardHolder  = holderField.value.trim();

  // 2.3) Crear PDF
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF({ unit: 'pt', format: 'letter' });

  // 2.4) Título
  doc.setFontSize(18);
  doc.setTextColor('#1F375B');
  doc.text('PinesNet — Comprobante de Pago', 40, 50);

  // 2.5) Tabla con todos los campos
  doc.autoTable({
    startY: 80,
    head: [['Concepto', 'Detalle']],
    body: [
      ['Plan',                data.plan],
      ['Datos incluidos',     data.gb],
      ['Vigencia',            data.vigencia],
      ['Precio plan (COP)',   `$ ${data.precioPlan.toLocaleString()}`],
      ['Precio base (COP)',   `$ ${data.precioBase.toLocaleString()}`],
      ['Comisión (COP)',      `$ ${data.comision.toFixed(2)}`],
      ['Total a pagar (COP)', `$ ${data.total.toFixed(2)}`],
      ['ID de factura',       data.invoiceId],
      ['Fecha de compra',     data.fechaCompra],
      ['Titular',             cardHolder],
      ['Tarjeta',             maskedCard],
      ['Fecha de expiración', data.fechaExpiracion],
    ],
    theme: 'grid',
    headStyles: { fillColor: '#01ABE4' },
    styles: { cellPadding: 6, fontSize: 12 }
  });

  // 2.6) Pie de página
  const pageHeight = doc.internal.pageSize.height;
  doc.setFontSize(10);
  doc.setTextColor('#555');
  doc.text('Gracias por su compra — PinesNet · soporte@pinesnet.com', 40, pageHeight - 40);

  // 2.7) Mostrar PDF en nueva pestaña
  window.open(doc.output('bloburl'), '_blank');
});
