// lib/views/users/js/profile.js

document.addEventListener('DOMContentLoaded', () => {
  // Avatar
  const uploadBtn   = document.getElementById('upload-btn');
  const avatarInput = document.getElementById('avatar-input');
  const avatarImg   = document.getElementById('avatar');
  const controls    = document.getElementById('preview-controls');
  const cancelBtn   = document.getElementById('cancel-btn');

  uploadBtn.addEventListener('click', () => avatarInput.click());
  avatarInput.addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = evt => {
      avatarImg.src = evt.target.result;
      controls.classList.remove('hidden');
      uploadBtn.classList.add('hidden');
    };
    reader.readAsDataURL(file);
  });
  cancelBtn.addEventListener('click', () => {
    avatarInput.value = '';
    avatarImg.src = 'get-avatar.php';
    controls.classList.add('hidden');
    uploadBtn.classList.remove('hidden');
  });

  // Modal de detalles
  const modal     = document.getElementById('detailsModal');
  const modalBody = document.getElementById('modal-body');
  const closeBtn  = modal.querySelector('.close');

  document.querySelectorAll('.btn-details').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.id;
      const detailsRow = document.getElementById('details-' + id);
      if (!detailsRow) return;
      // Clonar y mostrar en modal
      const table = detailsRow.querySelector('.detail-table').cloneNode(true);
      modalBody.innerHTML = '';
      modalBody.appendChild(table);
      modal.style.display = 'block';
    });
  });

  closeBtn.addEventListener('click', () => modal.style.display = 'none');
  window.addEventListener('click', e => {
    if (e.target === modal) modal.style.display = 'none';
  });
});
