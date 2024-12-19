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
            tablaProductos.deleteRow(nuevaFila.rowIndex - 1);
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
        const inputs = document.querySelectorAll("input");
        inputs.forEach(input => {
            if (!input.hasAttribute("readonly") && !input.hasAttribute("disabled")) {
                input.value = "";
            }
        });
    }

    // Función para actualizar el total de la venta
    function actualizarTotal() {
        let totalVenta = 0;
        for (let i = 0; i < tablaProductos.rows.length; i++) {
            const row = tablaProductos.rows[i];
            const totalConIva = parseInt(row.cells[8].textContent.replace('$', '').replace(',', '').trim());  // Total con IVA de cada producto
            totalVenta += totalConIva;
        }
        totalInput.value = `$${totalVenta}`;  // Mostrar el total final con IVA, redondeado a entero
    }

    // Al registrar venta, redirigir a confirm_sale.php
    registrarVentaBtn.addEventListener("click", function (event) {
        event.preventDefault(); // Evitar el envío del formulario

        // Verificar si la tabla tiene productos
        if (tablaProductos.rows.length === 0) {
            alert("No hay items de compra. Por favor, agregue productos.");
            return;  // Detener el proceso si no hay productos
        }

        // Crear un formulario dinámico para enviar los datos a confirm_sale.php
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "confirm_sale.php";  // Redirigir a esta página

        // Crear un array para los productos
        const productos = [];
        for (let i = 0; i < tablaProductos.rows.length; i++) {
            const row = tablaProductos.rows[i];
            const producto = {
                clienteIdentificacion: row.cells[0].textContent,
                clienteNombre: row.cells[1].textContent,
                productoCodigo: row.cells[2].textContent,
                productoDescripcion: row.cells[3].textContent,
                cantidad: parseInt(row.cells[4].textContent),  // Redondear cantidad a entero
                precioUnitario: parseInt(row.cells[5].textContent.replace('$', '').trim()),  // Redondear precio unitario a entero
                totalProducto: parseInt(row.cells[6].textContent.replace('$', '').trim()),  // Total sin IVA
                ivaProducto: row.cells[7].textContent,
                totalConIva: parseInt(row.cells[8].textContent.replace('$', '').trim())  // Total con IVA
            };            
            productos.push(producto);
        }

        // Crear un campo hidden para enviar los productos
        const inputProductos = document.createElement("input");
        inputProductos.type = "hidden";
        inputProductos.name = "productos";
        inputProductos.value = JSON.stringify(productos);  // Convertir a JSON
        form.appendChild(inputProductos);

        // Crear un campo hidden para el total de la venta
        const inputTotal = document.createElement("input");
        inputTotal.type = "hidden";
        inputTotal.name = "totalVenta";
        inputTotal.value = totalInput.value.replace('$', '').trim();
        form.appendChild(inputTotal);

        // Agregar el formulario al cuerpo del documento y enviarlo
        document.body.appendChild(form);
        form.submit();  // Enviar el formulario
    });
});
