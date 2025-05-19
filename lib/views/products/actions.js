// actions.js

document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('btn-siguiente');
  if (!btn) return;

  btn.addEventListener('click', () => {
    // 1) Verificar que hay un plan seleccionado
    const seleccionado = document.querySelector('input[name="plan"]:checked');
    if (!seleccionado) {
      alert('Para continuar debe seleccionar algún plan');
      return;
    }

    // 2) Verificar que el usuario está logueado
    if (!window.isLoggedIn) {
      const quiereIniciar = confirm(
        'Para continuar con su compra por favor inicie sesión. ¿Desea ir al login ahora?'
      );
      if (quiereIniciar) {
        window.location.href = '/lib/views/auth/login/login.php';
      }
      return;
    }

    // 3) Mapear cada plan (value del radio) a su precio real
const precios = {
  premium:   30000,
  pro:       15000,
  avanzado:  10000,
  esencial:   7000,
  basico:     1000
};

    const plan = seleccionado.value;       // debe ser 'premium','pro','avanzado','esencial' o 'basico'
    const precio = precios[plan] || 0;     // en COP

    // 4) Redirigir con el parámetro price correcto
    // Ajusta la ruta al lugar donde vivan tus archivos
    window.location.href = `../transaction/transactional.php?price=${precio}`;
  });
});
