// actions.js

document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('btn-siguiente');
  if (!btn) return;

  btn.addEventListener('click', () => {
    // 1) ¿Seleccionó un plan?
    const seleccionado = document.querySelector('input[name="plan"]:checked');
    if (!seleccionado) {
      alert('Para continuar debe seleccionar algún plan');
      return;
    }

    // 2) ¿Está logueado?
    if (!window.isLoggedIn) {
      const quiereIniciar = confirm(
        'Para continuar con su compra por favor inicie sesión. ¿Desea ir al login ahora?'
      );
      if (quiereIniciar) {
        window.location.href = '/lib/views/auth/login-register/login-register.php';
      }
      return;
    }

    // 3) Mapear plan → precio
    const precios = {
      premium:   30000,
      pro:       15000,
      avanzado:  10000,
      esencial:   7000,
      basico:     1000
    };
    const plan   = seleccionado.value;
    const precio = precios[plan] || 0;

    // 4) Redirigir con precio y plan
    window.location.href = `../transaction/transactional.php?price=${precio}&plan=${plan}`;
  });
});
