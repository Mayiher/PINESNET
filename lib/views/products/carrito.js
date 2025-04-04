// Variables globales
let carrito = [];
let total = 0;

// A�adir al carrito
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function () {
        const producto = this.closest('.producto');
        const nombre = producto.dataset.nombre;
        const precio = parseFloat(producto.dataset.precio);

        // A�adir producto al carrito
        carrito.push({ nombre, precio });
        total += precio;
        actualizarCarrito();
    });
});

// Actualizar la vista del carrito
function actualizarCarrito() {
    const listaCarrito = document.getElementById('lista-carrito');
    listaCarrito.innerHTML = ''; // Limpiar la lista

    if (carrito.length === 0) {
        listaCarrito.innerHTML = '<p>Tu carrito está vacío.</p>';
    } else {
        carrito.forEach((item, index) => {
            const itemCarrito = document.createElement('div');
            itemCarrito.classList.add('item-carrito');
            itemCarrito.innerHTML = `
                <p>${item.nombre} - $${item.precio.toFixed(2)}</p>
                <button class="remove-from-cart" data-index="${index}">Eliminar</button>
            `;
            listaCarrito.appendChild(itemCarrito);
        });

        // Agregar evento a los botones de eliminar
        document.querySelectorAll('.remove-from-cart').forEach(button => {
            button.addEventListener('click', function () {
                const index = parseInt(this.dataset.index);
                total -= carrito[index].precio;
                carrito.splice(index, 1);
                actualizarCarrito();
            });
        });
    }

    // Actualizar el total
    document.getElementById('total-carrito').querySelector('p').textContent = `Total: $${total.toFixed(2)}`;
}

// Funcionalidad del botón de pagar
document.getElementById('pagar').addEventListener('click', function () {
    if (carrito.length === 0) {
        alert('El carrito está vacío');
    } else {
        alert('Redirigiendo a la página de pago...');
        window.location.href = '../transactional-portal/transactional.php'; // Cambia 'ruta-local.html' por la ruta local deseada
    }
});
