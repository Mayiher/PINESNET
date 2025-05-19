
// Manejo de pestañas en transactional.php
document.querySelectorAll('.payment-panel .tab').forEach(tab => {
  tab.addEventListener('click', () => {
    document.querySelectorAll('.payment-panel .tab, .payment-panel .content')
      .forEach(el => el.classList.remove('active'));
    tab.classList.add('active');
    document.getElementById(tab.dataset.target).classList.add('active');
  });
});
