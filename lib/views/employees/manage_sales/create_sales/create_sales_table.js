document.addEventListener("DOMContentLoaded", function () {
  const agregarProductoBtn = document.getElementById("agregarProducto");
  const registrarVentaBtn  = document.getElementById("registrarVenta");
  const tablaProductos     = document
    .getElementById("tablaProductos")
    .getElementsByTagName("tbody")[0];
  const totalInput         = document.getElementById("total");

  agregarProductoBtn.addEventListener("click", function () {
    const clienteIdentificacion = document.getElementById("cliente_identificacion").value;
    const clienteNombre         = document.getElementById("Nombrecliente").value;
    const productoCodigo        = document.getElementById("producto_codigo").value;
    const productoDescripcion   = document.getElementById("producto_descripcion").value;
    const cantidad              = parseFloat(document.getElementById("cantidad").value);
    const precioUnitario        = parseFloat(document.getElementById("precio_unitario").value);

    if (
      !clienteIdentificacion ||
      !clienteNombre ||
      !productoCodigo ||
      !productoDescripcion ||
      !cantidad ||
      !precioUnitario
    ) {
      alert("Por favor, complete todos los campos.");
      return;
    }

    // Cálculos
    const bruto         = Math.round(cantidad * precioUnitario);
    const ivaPorcentaje = 19;
    const ivaProducto   = Math.round((bruto * ivaPorcentaje) / 100);
    const totalConIva   = bruto + ivaProducto;

    // Insertar nueva fila
    const nuevaFila = tablaProductos.insertRow();
    nuevaFila.insertCell(0).textContent = tablaProductos.rows.length;
    nuevaFila.insertCell(1).textContent = productoCodigo;
    nuevaFila.insertCell(2).textContent = productoDescripcion;
    nuevaFila.insertCell(3).textContent = cantidad;
    nuevaFila.insertCell(4).textContent = `$${precioUnitario.toFixed(2)}`;
    nuevaFila.insertCell(5).textContent = `$${bruto}`;
    nuevaFila.insertCell(6).textContent = `${ivaPorcentaje}%`;
    nuevaFila.insertCell(7).textContent = `$${totalConIva}`;

    // **Inserta el botón en la celda índice 8 (novena columna)**
    const celdaEliminar = nuevaFila.insertCell(8);
    const btnEliminar = document.createElement("button");
    btnEliminar.type = "button";                     // evita validar el form
    btnEliminar.textContent = "Eliminar";
    btnEliminar.classList.add("btn", "btn-danger");
    btnEliminar.addEventListener("click", (e) => {
      e.preventDefault();        // por si acaso
      nuevaFila.remove();        // elimina la fila
      actualizarTotal();         // recalcula total
    });
    celdaEliminar.appendChild(btnEliminar);

    vaciarCampos();
    actualizarTotal();
  });

  function vaciarCampos() {
    ["producto_codigo","producto_descripcion","cantidad","precio_unitario"]
      .forEach(id => document.getElementById(id).value = "");
  }

  function actualizarTotal() {
    let total = 0;
    for (let row of tablaProductos.rows) {
      const val = row.cells[7].textContent
                     .replace("$", "")
                     .replace(/\./g, "");
      total += parseFloat(val) || 0;
    }
    totalInput.value = `$${total.toFixed(2)}`;
  }

  registrarVentaBtn.addEventListener("click", function (e) {
    if (tablaProductos.rows.length === 0) {
      e.preventDefault();
      alert("Debe agregar al menos un producto antes de registrar la venta.");
    }
  });
});
