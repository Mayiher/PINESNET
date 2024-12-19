document.addEventListener("DOMContentLoaded", function () {
    const clienteIdentificacion = document.getElementById("cliente_identificacion");
    const clienteNombre = document.getElementById("Nombrecliente");
    const clienteApellido = document.getElementById("apellidoCliente");
    const clienteApellidoDiv = document.getElementById("apellidoClienteDiv");
    const consultarBtn = document.getElementById("consultarIdentificacion");

    // Variable para guardar los datos del cliente
    let clienteDatos = {};

    const popup = document.createElement("div");
    popup.id = "popup";
    popup.style.position = "fixed";
    popup.style.top = "0";
    popup.style.left = "0";
    popup.style.width = "100%";
    popup.style.height = "100%";
    popup.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
    popup.style.display = "none";
    popup.style.justifyContent = "center";
    popup.style.alignItems = "center";
    popup.style.zIndex = "9999";
    popup.innerHTML = `<div style="background: white; padding: 20px; border-radius: 5px; font-size: 18px;">Buscando cliente...</div>`;
    document.body.appendChild(popup);

    const opcionPopup = document.createElement("div");
    opcionPopup.id = "opcionPopup";
    opcionPopup.style.position = "fixed";
    opcionPopup.style.top = "0";
    opcionPopup.style.left = "0";
    opcionPopup.style.width = "100%";
    opcionPopup.style.height = "100%";
    opcionPopup.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
    opcionPopup.style.display = "none";
    opcionPopup.style.justifyContent = "center";
    opcionPopup.style.alignItems = "center";
    opcionPopup.style.zIndex = "9999";
    opcionPopup.innerHTML = `
        <div style="background: white; padding: 20px; border-radius: 5px; font-size: 18px; text-align: center;">
            <p>Cliente no encontrado. ¿Desea registrar un nuevo cliente?</p>
            <button id="registrarClienteBtn" style="margin: 10px;" class="btn-style">Registrar Cliente para Compra</button>
            <button id="noRegistrarClienteBtn" style="margin: 10px;" class="btn-style">No Registrar</button>
        </div>`;
    document.body.appendChild(opcionPopup);

    // Estilo para los botones
    const buttonStyle = `
        .btn-style {
            background-color: #4CAF50; /* Verde */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
            transition-duration: 0.4s;
        }

        .btn-style:hover {
            background-color: white;
            color: black;
            border: 1px solid #4CAF50;
        }
    `;
    
    // Incluir los estilos en el documento
    const styleSheet = document.createElement("style");
    styleSheet.type = "text/css";
    styleSheet.innerText = buttonStyle;
    document.head.appendChild(styleSheet);

    // Ocultar el botón "Consultar Identificación"
    function ocultarConsultarBtn() {
        consultarBtn.style.display = "none";
        console.log("Botón 'Consultar Identificación' ocultado.");
    }

    // Evento al hacer clic en "Consultar Identificación"
    consultarBtn.addEventListener("click", function () {
        console.log("Botón 'Consultar Identificación' presionado");

        const identificacion = clienteIdentificacion.value;
        console.log("Identificación ingresada:", identificacion);

        if (!identificacion) {
            alert("Debe ingresar el número de identificación.");
            return;
        }

        popup.style.display = "flex";
        console.log("Popup de búsqueda mostrado...");

        fetch('search_client.php?identificacion=' + identificacion)
            .then(response => {
                console.log("Respuesta de la búsqueda recibida:", response);
                return response.json();
            })
            .then(data => {
                console.log("Datos del cliente recibidos:", data);

                if (data.success) {
                    console.log("Cliente encontrado, nombre completo:", data.nombre_completo);
                    clienteNombre.value = data.nombre_completo;
                    clienteApellido.value = data.apellido_completo; // Asegurarse que el apellido se carga correctamente
                    clienteNombre.readOnly = true;
                    clienteIdentificacion.readOnly = true;

                    ocultarConsultarBtn();
                    popup.style.display = "none";
                } else {
                    console.log("Cliente no encontrado, mostrando opción de registro...");
                    popup.style.display = "none";
                    opcionPopup.style.display = "flex";

                    // Vincular eventos de los botones al mostrar el popup
                    document.getElementById("registrarClienteBtn").addEventListener("click", registrarCliente);
                    document.getElementById("noRegistrarClienteBtn").addEventListener("click", noRegistrarCliente);
                }
            })
            .catch(error => {
                console.error('Error al buscar cliente:', error);
                popup.style.display = "none";
            });
    });

    // Función para "Registrar Cliente para la Compra"
    function registrarCliente() {
        console.log("El usuario ha elegido registrar un nuevo cliente.");

        // Ocultar el botón de "Registrar Cliente para Compra" cuando se presiona
        document.getElementById("registrarClienteBtn").style.display = "none";

        clienteNombre.value = ""; // Limpiar nombre
        clienteApellidoDiv.style.display = "block"; // Mostrar el campo apellido
        clienteIdentificacion.readOnly = true; // Bloquear identificación
        clienteNombre.readOnly = false; // Habilitar campo nombre
        clienteApellido.readOnly = false; // Habilitar campo apellido

        ocultarConsultarBtn();
        opcionPopup.style.display = "none";

        // Crear el botón "Registrar Cliente para Compra" debajo de Apellido del cliente
        const registrarCompraBtn = document.createElement("button");
        registrarCompraBtn.id = "registrarCompraBtn";
        registrarCompraBtn.textContent = "Registrar Cliente para Compra";
        registrarCompraBtn.classList.add("btn-style"); // Aplicar el mismo estilo que el botón de consultar
        registrarCompraBtn.style.marginTop = "10px";
        clienteApellidoDiv.appendChild(registrarCompraBtn); // Agregar el botón al DOM debajo de Apellido

        // Vincular el evento para registrar cliente para la compra
        registrarCompraBtn.addEventListener("click", function () {
            console.log("Cliente registrado para la compra.");

            // Obtener los datos del cliente
            const identificacion = clienteIdentificacion.value;
            const nombre = clienteNombre.value;
            const apellido = clienteApellido.value;

            // Asegurarnos de que el apellido no se borre
            if (!apellido) {
                alert("Debe ingresar el apellido del cliente.");
                return;
            }

            // Guardar los datos del cliente en la variable clienteDatos
            clienteDatos = {
                identificacion: identificacion,
                nombre: nombre,
                apellido: apellido
            };

            console.log("Datos del cliente guardados:", clienteDatos);

            // Vaciar los campos del formulario
            vaciarCamposFormulario();

            // Hacer los campos de nombre, apellido y identificación solo lectura
            clienteNombre.readOnly = true;
            clienteApellido.readOnly = true;

            // **NO limpiar ni ocultar** el apellido, lo mantenemos visible
            clienteApellido.value = apellido; // Aseguramos que el apellido quede visible y no se borre

            // Ocultar el botón "Registrar Cliente para Compra" después de registrar
            registrarCompraBtn.style.display = "none";
        });

        console.log("Campo de identificación configurado en solo lectura para el registro del cliente.");
    }

// Función para "No Registrar" al no encontrar al cliente
function noRegistrarCliente() {
    console.log("El usuario ha elegido no registrar al cliente.");

    // Establecer valores predeterminados en los campos de cliente
    clienteIdentificacion.value = "222222222222";  // Valor por defecto
    clienteNombre.value = "Caja Tienda";            // Nombre por defecto
    clienteApellido.value = "";                     // Dejar vacío el apellido

    // Cambiar los campos de Identificación y Nombre a solo lectura
    clienteIdentificacion.readOnly = true;
    clienteNombre.readOnly = true;

    // Ocultar el popup de opciones
    opcionPopup.style.display = "none";

    // Ocultar el botón "Consultar Identificación"
    consultarBtn.style.display = "none";
}

    // Función para vaciar los campos del formulario
    function vaciarCamposFormulario() {
        const formulario = document.getElementById("formularioVenta");
        const campos = formulario.querySelectorAll("input, select");

        campos.forEach(function (campo) {
            if (!campo.readOnly && campo.id !== "cliente_identificacion" && campo.id !== "Nombrecliente") {
                campo.value = "";
            }
        });
    }
});
