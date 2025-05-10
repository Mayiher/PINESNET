document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('btn-siguiente');
  if (!btn) return;

  btn.addEventListener('click', () => {
    const seleccionado = document.querySelector('input[name="plan"]:checked');

    if (!seleccionado) {
      alert('Para continuar debe seleccionar algún plan');
      return;
    }

    if (!window.isLoggedIn) {
      const quiereIniciar = confirm(
        'Para continuar con su compra por favor inicie sesión. ¿Desea ir al login ahora?'
      );
      if (quiereIniciar) {
        window.location.href = '/lib/views/auth/login/login.php';
      }
      return;
    }

    window.location.href = '../transaction/transactional.php';
  });
});

