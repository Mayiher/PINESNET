// Función para mostrar la alerta y redirigir al login después de un tiempo
function showConnectionErrorAndRedirect() {
    alert("No se ha podido conectar a la base de datos");

    // Redirigir a la página de login después de 2 segundos
    setTimeout(function() {
        window.location = "/lib/views/auth/login/login.php";
    }, 2000); // 2000 ms = 2 segundos
}

// Llamar a la función cuando se cargue la ventana
window.onload = function() {
    showConnectionErrorAndRedirect();
};
