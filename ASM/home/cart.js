// cart.js
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Initialize cart when page loads
document.addEventListener('DOMContentLoaded', function () {
    updateCartCount();
    renderCartPage(); // Only runs on cart.html
});

// Add to cart functionality
document.querySelectorAll('.product-card button').forEach(button => {
    button.addEventListener('click', function () {
        const productCard = this.closest('.product-card');
        const product = {
            name: productCard.querySelector('h3').textContent,
            price: parsePrice(productCard.querySelector('.price').textContent),
            image: fixImagePath(productCard.querySelector('img').src),
            quantity: 1
        };

        // Check for sale price
        const salePriceElement = productCard.querySelector('.sale-price');
        if (salePriceElement) {
            product.price = parsePrice(salePriceElement.textContent);
            product.originalPrice = parsePrice(productCard.querySelector('.original-price').textContent);
        }

        addToCart(product);
    });
});

// Helper function to parse price strings into numbers
function parsePrice(priceString) {
    return parseInt(priceString.replace(/[^0-9]/g, ''));
}

// Helper function to fix image paths
function fixImagePath(path) {
    if (path.includes('../img/')) {
        return path.replace('../img/', 'img/');
    }
    return path;
}

// Main add to cart function
function addToCart(product) {
    const existingItem = cart.find(item => item.name === product.name);

    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push(product);
    }

    saveCart();
    updateCartCount();
    showAddToCartNotification(product.name);
}

// Save cart to localStorage
function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
}

// Update cart count in header
function updateCartCount() {
    const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
    const cartCountElements = document.querySelectorAll('.cart-count');

    cartCountElements.forEach(element => {
        element.textContent = totalItems;
    });
}

// Show notification when product is added
function showAddToCartNotification(productName) {
    const notification = document.createElement('div');
    notification.className = 'cart-notification';
    notification.innerHTML = `
        <span>${productName} added to cart!</span>
        <a href="cart.html">View Cart</a>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.add('show');
    }, 10);

    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Render cart page (only on cart.html)
function renderCartPage() {
    const cartItemsContainer = document.querySelector('.cart-items');
    if (!cartItemsContainer) return;

    if (cart.length === 0) {
        cartItemsContainer.innerHTML = '<div class="empty-cart">Your cart is empty</div>';
        updateCartSummary(0);
        return;
    }

    let itemsHTML = '';
    let subtotal = 0;

    cart.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;

        itemsHTML += `
            <div class="cart-item" data-index="${index}">
                <div class="item-image">
                    <img src="${item.image}" alt="${item.name}">
                </div>
                <div class="item-details">
                    <h3>${item.name}</h3>
                    <p class="item-price">${formatPrice(item.price)} VND</p>
                    <div class="item-quantity">
                        <button class="quantity-btn minus">-</button>
                        <span class="quantity">${item.quantity}</span>
                        <button class="quantity-btn plus">+</button>
                    </div>
                    <button class="remove-btn">Remove</button>
                </div>
                <div class="item-total">
                    <p>${formatPrice(itemTotal)} VND</p>
                </div>
            </div>
        `;
    });

    cartItemsContainer.innerHTML = itemsHTML;
    updateCartSummary(subtotal);

    // Add event listeners for quantity changes
    document.querySelectorAll('.quantity-btn.minus').forEach(button => {
        button.addEventListener('click', function () {
            const index = this.closest('.cart-item').dataset.index;
            updateQuantity(index, -1);
        });
    });

    document.querySelectorAll('.quantity-btn.plus').forEach(button => {
        button.addEventListener('click', function () {
            const index = this.closest('.cart-item').dataset.index;
            updateQuantity(index, 1);
        });
    });

    // Add event listeners for remove buttons
    document.querySelectorAll('.remove-btn').forEach(button => {
        button.addEventListener('click', function () {
            const index = this.closest('.cart-item').dataset.index;
            removeItem(index);
        });
    });
}

// Update item quantity
function updateQuantity(index, change) {
    const item = cart[index];
    item.quantity += change;

    if (item.quantity < 1) {
        item.quantity = 1;
    }

    saveCart();
    renderCartPage();
}

// Remove item from cart
function removeItem(index) {
    cart.splice(index, 1);
    saveCart();
    renderCartPage();
    updateCartCount();
}

// Update cart summary section
function updateCartSummary(subtotal) {
    const shipping = 30000;
    const total = subtotal + shipping;

    document.querySelector('.subtotal').textContent = `${formatPrice(subtotal)} VND`;
    document.querySelector('.total-price').textContent = `${formatPrice(total)} VND`;
}

// Format price with commas
function formatPrice(price) {
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}