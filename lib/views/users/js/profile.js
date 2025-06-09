// profile.js
document.addEventListener('DOMContentLoaded', () => {
  const uploadBtn   = document.getElementById('upload-btn');
  const avatarInput = document.getElementById('avatar-input');
  const avatarImg   = document.getElementById('avatar');
  const controls    = document.getElementById('preview-controls');
  const cancelBtn   = document.getElementById('cancel-btn');

  uploadBtn.addEventListener('click', () => avatarInput.click());

  avatarInput.addEventListener('change', (e) => {
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
});
