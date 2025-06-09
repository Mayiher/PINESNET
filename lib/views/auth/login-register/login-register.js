function showForm(form) {
  const loginForm = document.getElementById('login-form');
  const registerForm = document.getElementById('register-form');
  const tabs = document.querySelectorAll('.tab');

  // Eliminar clases activas de los tabs
  tabs.forEach(tab => tab.classList.remove('active'));

  // Agregar clase activa al botón actual
  if (form === 'login') {
    tabs[0].classList.add('active');
  } else {
    tabs[1].classList.add('active');
  }

  // Transición con opacidad
  const currentForm = form === 'login' ? registerForm : loginForm;
  const newForm = form === 'login' ? loginForm : registerForm;

  currentForm.classList.add('fade-out');

  setTimeout(() => {
    currentForm.classList.add('hidden');
    currentForm.classList.remove('fade-out');

    newForm.classList.remove('hidden');
    newForm.classList.add('fade-in');

    setTimeout(() => {
      newForm.classList.remove('fade-in');
    }, 300); // Duración de la animación
  }, 300);
}
