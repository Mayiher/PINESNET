let slideIndex = 0;
showSlide(slideIndex);

function nextSlide() {
    slideIndex++;
    showSlide(slideIndex);
}

function prevSlide() {
    slideIndex--;
    showSlide(slideIndex);
}

function showSlide(index) {
    const slides = document.querySelectorAll('.carousel-inner img');
    if (index >= slides.length) slideIndex = 0;
    if (index < 0) slideIndex = slides.length - 1;

    slides.forEach((slide, i) => {
        slide.classList.remove('active');
        if (i === slideIndex) slide.classList.add('active');
    });
}

document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();
    alert('Iniciar sesión completada.');
});

document.getElementById('registerForm').addEventListener('submit', function(event) {
    event.preventDefault();
    alert('Registro completado. Ahora puedes iniciar sesión.');
    window.location.href = '#login';
});
