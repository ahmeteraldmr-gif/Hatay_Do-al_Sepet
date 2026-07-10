document.addEventListener('DOMContentLoaded', () => {
    // --- ELEMENT SEÇİCİLER ---
    const header = document.querySelector('.header');
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    const cartBtn = document.getElementById('cart-btn');
    const cartDrawer = document.getElementById('cart-drawer');
    const cartClose = document.getElementById('cart-close');
    const overlay = document.getElementById('overlay');
    const cartItemsList = document.getElementById('cart-items-list');
    const cartCountBadges = document.querySelectorAll('.cart-badge');
    const cartTotalAmount = document.getElementById('cart-total-amount');
    const whatsappOrderBtn = document.getElementById('whatsapp-order-btn');

    // --- SEPET DURUMU (State) ---
    let cart = JSON.parse(localStorage.getItem('hds_cart')) || [];

    // --- HEADER KAYDIRMA EFEKTİ ---
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // --- MOBİL MENÜ ---
    if (hamburger && navMenu) {
        hamburger.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            hamburger.classList.toggle('active');
            header.classList.toggle('menu-open');
        });
    }

    // --- SEPET DRAWER KONTROLLERİ ---
    function openCart() {
        if (cartDrawer && overlay) {
            cartDrawer.classList.add('active');
            overlay.classList.add('active');
        }
    }

    function closeCart() {
        if (cartDrawer && overlay) {
            cartDrawer.classList.remove('active');
            overlay.classList.remove('active');
        }
        if (navMenu && hamburger) {
            navMenu.classList.remove('active');
            hamburger.classList.remove('active');
            header.classList.remove('menu-open');
        }
    }

    if (cartBtn) cartBtn.addEventListener('click', openCart);
    if (cartClose) cartClose.addEventListener('click', closeCart);
    if (overlay) overlay.addEventListener('click', () => {
        closeCart();
        if (navMenu && hamburger) {
            navMenu.classList.remove('active');
        }
    });

    // --- SEPET İŞLEMLERİ (Cart Operations) ---
    window.addToCart = function(id, name, price, img) {
        const parsedPrice = parseFloat(price);
        const existingItem = cart.find(item => item.id === id);
        
        if (existingItem) {
            existingItem.qty += 1;
        } else {
            cart.push({ id, name, price: parsedPrice, img, qty: 1 });
        }
        
        saveCart();
        updateCartUI();
        openCart();
    };

    function saveCart() {
        localStorage.setItem('hds_cart', JSON.stringify(cart));
    }

    function updateCartUI() {
        if (!cartItemsList) return;
        
        cartItemsList.innerHTML = '';
        
        if (cart.length === 0) {
            cartItemsList.innerHTML = '<div class="cart-empty-message">Sepetiniz şu anda boş.</div>';
            cartCountBadges.forEach(badge => badge.textContent = '0');
            if (cartTotalAmount) cartTotalAmount.textContent = '0,00 TL';
            return;
        }

        let total = 0;
        let itemCount = 0;

        cart.forEach(item => {
            total += item.price * item.qty;
            itemCount += item.qty;

            const itemEl = document.createElement('div');
            itemEl.className = 'cart-item';
            itemEl.innerHTML = `
                <img src="${item.img}" alt="${item.name}" class="cart-item-img">
                <div class="cart-item-info">
                    <div class="cart-item-name">${item.name}</div>
                    <div class="cart-item-price">${(item.price * item.qty).toFixed(2)} TL</div>
                    <div class="cart-item-qty">
                        <button class="qty-btn" onclick="updateQty('${item.id}', -1)">-</button>
                        <span>${item.qty} adet</span>
                        <button class="qty-btn" onclick="updateQty('${item.id}', 1)">+</button>
                    </div>
                </div>
                <div class="cart-item-remove" onclick="removeFromCart('${item.id}')">✕</div>
            `;
            cartItemsList.appendChild(itemEl);
        });

        cartCountBadges.forEach(badge => badge.textContent = itemCount.toString());
        if (cartTotalAmount) cartTotalAmount.textContent = total.toFixed(2) + ' TL';
    }

    window.updateQty = function(id, change) {
        const item = cart.find(item => item.id === id);
        if (item) {
            item.qty += change;
            if (item.qty <= 0) {
                cart = cart.filter(item => item.id !== id);
            }
            saveCart();
            updateCartUI();
        }
    };

    window.removeFromCart = function(id) {
        cart = cart.filter(item => item.id !== id);
        saveCart();
        updateCartUI();
    };

    // --- WHATSAPP ENTEGRASYONU ---
    if (whatsappOrderBtn) {
        whatsappOrderBtn.addEventListener('click', () => {
            if (cart.length === 0) return;
            
            let message = `Merhaba, Hatay Doğal Sepet web sitenizden aşağıdaki ürünleri sipariş etmek istiyorum:\n\n`;
            let total = 0;
            
            cart.forEach((item, index) => {
                const subtotal = item.price * item.qty;
                total += subtotal;
                message += `${index + 1}. *${item.name}* - ${item.qty} Adet (${subtotal.toFixed(2)} TL)\n`;
            });
            
            message += `\n*Toplam Tutar:* ${total.toFixed(2)} TL\n`;
            message += `\nLütfen sipariş süreci ve kargo detayları hakkında bilgi verebilir misiniz?`;
            
            // Telefon numarası girilecek (örnek 905000000000)
            const phoneNumber = window.WHATSAPP_NUMBER || "905551234567"; 
            const encodedMessage = encodeURIComponent(message);
            const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
            
            window.open(whatsappUrl, '_blank');
        });
    }

    // --- ÜRÜN FİLTRELEME MANTIĞI (Products Filter) ---
    const filterBtns = document.querySelectorAll('.filter-btn');
    const productItems = document.querySelectorAll('.product-card-item');

    if (filterBtns.length > 0 && productItems.length > 0) {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Aktif butonu güncelle
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filterValue = btn.getAttribute('data-filter');

                productItems.forEach(item => {
                    const category = item.getAttribute('data-category');
                    if (filterValue === 'all' || category === filterValue) {
                        item.style.display = 'flex';
                        // Giriş animasyonu
                        item.style.opacity = '0';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transition = 'opacity 0.4s ease';
                        }, 50);
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // URL parametresine göre otomatik filtreleme (örn: urunler.html?kat=defne)
        const urlParams = new URLSearchParams(window.location.search);
        const katParam = urlParams.get('kat');
        if (katParam) {
            const targetBtn = document.querySelector(`.filter-btn[data-filter="${katParam}"]`);
            if (targetBtn) {
                setTimeout(() => {
                    targetBtn.click();
                }, 100);
            }
        }
    }

    // İlk yüklemede sepeti güncelle
    updateCartUI();
});
