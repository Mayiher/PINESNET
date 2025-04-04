document.addEventListener("DOMContentLoaded", function () {
    const agregarProductoBtn = document.getElementById("agregarProducto");
    const registrarVentaBtn = document.getElementById("registrarVenta"); // Botón de registrar venta
    const tablaProductos = document.getElementById("tablaProductos").getElementsByTagName("tbody")[0];
    const totalInput = document.getElementById("total");

    // Función para agregar producto a la tabla
    agregarProductoBtn.addEventListener("click", function () {
        const clienteIdentificacion = document.getElementById("cliente_identificacion").value;
        const clienteNombre = document.getElementById("Nombrecliente").value;
        const productoCodigo = document.getElementById("producto_codigo").value;
        const productoDescripcion = document.getElementById("producto_descripcion").value;
        const cantidad = parseFloat(document.getElementById("cantidad").value);
        const precioUnitario = parseFloat(document.getElementById("precio_unitario").value);

        if (!clienteIdentificacion || !clienteNombre || !productoCodigo || !productoDescripcion || !cantidad || !precioUnitario) {
            alert("Por favor, complete todos los campos.");
            return;
        }

        // Calcular total y IVA
        const bruto = Math.round(cantidad * precioUnitario); // Total bruto (sin IVA), redondeado a entero
        const ivaPorcentaje = 19; // Ejemplo: 19% de IVA
        const ivaProducto = Math.round((bruto * ivaPorcentaje) / 100); // IVA del producto, redondeado a entero
        const totalConIva = bruto + ivaProducto; // Total con IVA, redondeado a entero

        // Crear una nueva fila en la tabla
        const nuevaFila = tablaProductos.insertRow();

        // Insertar las celdas en la fila
        nuevaFila.insertCell(0).textContent = clienteIdentificacion;
        nuevaFila.insertCell(1).textContent = clienteNombre;
        nuevaFila.insertCell(2).textContent = productoCodigo;
        nuevaFila.insertCell(3).textContent = productoDescripcion;
        nuevaFila.insertCell(4).textContent = Math.round(cantidad); // Redondear cantidad a entero
        nuevaFila.insertCell(5).textContent = `$${Math.round(precioUnitario)}`; // Redondear precio unitario a entero y agregar el signo '$'
        nuevaFila.insertCell(6).textContent = `$${bruto}`;  // Total bruto sin IVA con el signo '$'
        nuevaFila.insertCell(7).textContent = `${ivaPorcentaje}%`;  // Mostrar porcentaje de IVA
        nuevaFila.insertCell(8).textContent = `$${totalConIva}`;  // Total con IVA con el signo '$'

        // Botón para eliminar producto de la tabla
        const btnEliminar = document.createElement("button");
        btnEliminar.textContent = "Eliminar";
        btnEliminar.classList.add("btn", "btn-danger");
        btnEliminar.onclick = function () {
            tablaProductos.deleteRow(nuevaFila.rowIndex);
            actualizarTotal(); // Recalcular el total al eliminar un producto
        };
        nuevaFila.insertCell(9).appendChild(btnEliminar);

        // Actualizar el total de la venta
        actualizarTotal();

        // Vaciar los campos que no son solo lectura
        vaciarCampos();
    });

    // Función para vaciar campos no readonly
    function vaciarCampos() {
        document.getElementById("producto_codigo").value = "";
        document.getElementById("producto_descripcion").value = "";
        document.getElementById("cantidad").value = "";
        document.getElementById("precio_unitario").value = "";
    }

    // Función para actualizar el total de la venta
    function actualizarTotal() {
        let total = 0;

        for (let i = 0; i < tablaProductos.rows.length; i++) {
            const row = tablaProductos.rows[i];
            const totalConIva = parseFloat(row.cells[8].textContent.replace('$', '').replace(',', ''));
            total += totalConIva;
        }

        totalInput.value = `$${Math.round(total)}`; // Mostrar el total con el signo '$' y redondeado
    }

    // Enviar datos al backend cuando se registre la venta
    registrarVentaBtn.addEventListener("click", function () {
        const clienteIdentificacion = document.getElementById("cliente_identificacion").value;
        const productos = [];
        for (let i = 0; i < tablaProductos.rows.length; i++) {
            const row = tablaProductos.rows[i];
            productos.push({
                producto_codigo: row.cells[2].textContent,
                producto_descripcion: row.cells[3].textContent,
                cantidad: parseInt(row.cells[4].textContent),
                precio_unitario: parseFloat(row.cells[5].textContent.replace('$', '').replace(',', '')),
                bruto: parseInt(row.cells[6].textContent.replace('$', '').replace(',', '')),
                iva: parseInt(row.cells[7].textContent.replace('%', '')),
                total: parseInt(row.cells[8].textContent.replace('$', '').replace(',', ''))
            });
        }

        const total = totalInput.value.replace('$', '').replace(',', '');

        // Realizar la solicitud fetch al backend para registrar la venta
        fetch('save_data.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                cliente_identificacion: clienteIdentificacion,
                productos: productos,
                total: total
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
            } else {
                alert(data.message);
            }
        });
    });
});
