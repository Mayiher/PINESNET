// js/AdminPanel.js

const sectionFields = {
  'Administradores': ['identificacion','nombre','apellido','correo','telefono','genero','password'],
  'Clientes'       : ['identificacion','nombre','apellido','correo','telefono','genero','password'],
  'Ventas'         : ['id_venta','id_usuario','fecha','subtotal','total_iva','descuento','total']
};

const sectionEndpoints = {
  'Administradores':'api/users/api-users.php',
  'Clientes'       :'api/users/api-users.php',
  'Ventas'         :'api/sales/api-sales.php'
};

let activeSection = document.querySelector('.breadcrumb .muted').textContent;
let editingId = null;

function openModal(item = null) {
  const form = document.getElementById('crudForm');
  form.innerHTML = '';
  editingId = item ? (item['identificacion'] || item['id_venta']) : null;

  document.getElementById('modalTitle').textContent = item
    ? `Editar ${activeSection.slice(0, -1)}`
    : `Nuevo ${activeSection.slice(0, -1)}`;

  sectionFields[activeSection].forEach(f => {
    if (f === 'password' && item) return;

    const label = document.createElement('label');
    label.textContent = f.replace('_',' ').replace(/^\w/,c=>c.toUpperCase());
    label.appendChild(document.createElement('br'));

    let input;
    if (f === 'genero') {
      input = document.createElement('select');
      input.name = 'genero';
      ['Masculino','Femenino'].forEach(optValue => {
        const option = document.createElement('option');
        option.value = optValue;
        option.textContent = optValue;
        if (item && item.genero === optValue) option.selected = true;
        input.appendChild(option);
      });
    } else {
      input = document.createElement('input');
      input.name = f;
      input.type = f.includes('fecha') ? 'date'
                 : (f === 'password' ? 'password' : 'text');
      input.value = item?.[f] ?? '';
    }

    if ((f === 'identificacion' || f === 'id_venta') && item) {
      input.readOnly = true;
    }

    label.appendChild(input);
    form.appendChild(label);
  });

  document.getElementById('crudModal').style.display = 'flex';
}

function closeModal() {
  document.getElementById('crudModal').style.display = 'none';
  editingId = null;
}

async function handleSave() {
  const formEl = document.getElementById('crudForm');
  const data = {};
  new FormData(formEl).forEach((v,k)=>data[k]=v.trim());

  for (let f of sectionFields[activeSection]) {
    if (f !== 'password' && !data[f]) {
      return alert(`El campo ${f} es obligatorio.`);
    }
  }

  if (!editingId) {
    data.rol = activeSection === 'Administradores' ? 'administrator' : 'user';
  }

  const endpoint = sectionEndpoints[activeSection];
  const url = editingId ? `${endpoint}?id=${editingId}` : endpoint;

  try {
    const res = await fetch(url, {
      method: 'POST',
      headers: {'Content-Type':'application/json'},
      body: JSON.stringify(data)
    });
    const payload = await res.json();
    if (!res.ok) throw new Error(payload.error || res.statusText);

    closeModal();
    location.reload();
  } catch (e) {
    alert('Error al guardar: ' + e.message);
  }
}

async function handleDelete(section, id) {
  if (!confirm('¿Eliminar este registro?')) return;
  const url = sectionEndpoints[section] + `?id=${id}`;
  try {
    const res = await fetch(url, { method: 'DELETE' });
    const payload = await res.json();
    if (!res.ok) throw new Error(payload.error || res.statusText);

    location.reload();
  } catch (e) {
    alert('Error al eliminar: ' + e.message);
  }
}

// ------------- Detalles de venta -------------
async function viewDetails(idVenta) {
  try {
    const res = await fetch(`api/sales_details/api-sales_details.php?id=${idVenta}`);
    if (!res.ok) throw new Error(`Error ${res.status}`);
    const details = await res.json();

    let html = `<table class="detail-table">
      <thead><tr>
        <th>Código</th><th>Descripción</th>
        <th>Cantidad</th><th>Precio U.</th><th>Total</th>
      </tr></thead><tbody>`;
    details.forEach(d => {
      html += `<tr>
        <td>${d.codigo_producto}</td>
        <td>${d.descripcion}</td>
        <td>${d.cantidad}</td>
        <td>$${Number(d.precio_unitario).toLocaleString()}</td>
        <td>$${Number(d.total).toLocaleString()}</td>
      </tr>`;
    });
    html += `</tbody></table>`;

    document.getElementById('detailsContent').innerHTML = html;
    document.getElementById('detailsModal').style.display = 'flex';
  } catch (err) {
    alert('No se pudieron cargar los detalles: ' + err.message);
  }
}

function closeDetails() {
  document.getElementById('detailsModal').style.display = 'none';
}
window.addEventListener('click', e => {
  if (e.target.id === 'detailsModal') closeDetails();
});
