document.addEventListener('DOMContentLoaded', () => {
  const inner    = document.querySelector('.carousel-inner');
  const items    = Array.from(document.querySelectorAll('.carousel-item'));
  const prevBtn  = document.querySelector('.prev');
  const nextBtn  = document.querySelector('.next');
  const interval = 5000;
  let   index    = 1;       // arrancamos en el primer slide “real”
  let   timer;
  let   isTransitioning = false;

  if (!inner || items.length === 0) return;

  // Clonar último y primer slide
  const firstClone = items[0].cloneNode(true);
  const lastClone  = items[items.length - 1].cloneNode(true);
  inner.appendChild(firstClone);
  inner.insertBefore(lastClone, inner.firstChild);

  const total = items.length + 2; // original + 2 clones

  // Posicionar sin animación al slide inicial real
  inner.style.transition = 'none';
  inner.style.transform  = `translateX(${-100 * index}%)`;
  void inner.offsetWidth; // forzar reflow

  // Actualiza con transición
  function update() {
    isTransitioning = true;
    inner.style.transition = 'transform 0.6s ease-in-out';
    inner.style.transform  = `translateX(${-100 * index}%)`;
  }

  // Al terminar la transición, corregimos si estamos en un clon
  inner.addEventListener('transitionend', () => {
    if (index === 0) {
      inner.style.transition = 'none';
      index = total - 2;
      inner.style.transform = `translateX(${-100 * index}%)`;
    }
    if (index === total - 1) {
      inner.style.transition = 'none';
      index = 1;
      inner.style.transform = `translateX(${-100 * index}%)`;
    }
    // Re-enable clicks y resume automática
    isTransitioning = false;
  });

  // Auto-advance continuo
  function startAuto() {
    clearInterval(timer);
    timer = setInterval(() => {
      if (isTransitioning) return;
      index++;
      update();
    }, interval);
  }

  // Handler “prev”
  prevBtn.addEventListener('click', () => {
    if (isTransitioning) return;
    clearInterval(timer);
    index--;
    update();
    startAuto();
  });

  // Handler “next”
  nextBtn.addEventListener('click', () => {
    if (isTransitioning) return;
    clearInterval(timer);
    index++;
    update();
    startAuto();
  });

  // Inicializamos todo
  startAuto();
});
