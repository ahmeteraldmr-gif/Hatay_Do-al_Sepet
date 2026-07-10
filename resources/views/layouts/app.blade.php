<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | {{ \App\Models\Setting::getValue('site_title', 'Hatay Doğal Sepet') }}</title>
    <meta name="description" content="@yield('meta_description', \App\Models\Setting::getValue('site_tagline', 'Hatay\'ın geleneksel yöntemleriyle sızma zeytinyağı ve defne yağından üretilen el yapımı doğal sabunları keşfedin.'))">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- FontAwesome Icons for Admin link and extra components -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Dynamic WhatsApp Number for JS -->
    <script>
        window.WHATSAPP_NUMBER = "{{ \App\Models\Setting::getValue('whatsapp_number', '905551234567') }}";
    </script>
</head>
<body>

    <!-- --- OVERLAY --- -->
    <div class="overlay" id="overlay"></div>

    <!-- --- HEADER / NAVIGATION --- -->
    <header class="header">
        <div class="container navbar">
            <a href="{{ route('home') }}" class="logo">
                <span class="logo-icon">🌿</span> {{ \App\Models\Setting::getValue('site_title', 'Hatay Doğal Sepet') }}
            </a>
            
            <nav class="nav-menu" id="nav-menu">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Ana Sayfa</a>
                <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">Ürünlerimiz</a>
                <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Hikayemiz</a>
                <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">İletişim</a>
            </nav>

            <div class="nav-actions">
                <div class="cart-icon" id="cart-btn" aria-label="Sepeti Görüntüle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                    <span class="cart-badge">0</span>
                </div>
                
                <div class="hamburger" id="hamburger" aria-label="Menü">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    @yield('content')

    <!-- --- FOOTER --- -->
    <footer class="footer">
        <div class="container footer-grid">
            <div class="footer-brand">
                <h3>🌿 {{ \App\Models\Setting::getValue('site_title', 'Hatay Doğal Sepet') }}</h3>
                <p>Hatay'ın binlerce yıllık geleneksel ve el yapımı sabun kültürünü en saf haliyle kapınıza getiriyoruz.</p>
                <div class="footer-socials">
                    <a href="#" class="social-link" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                    <a href="#" class="social-link" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    </a>
                </div>
            </div>
            
            <div class="footer-links">
                <h4 class="footer-title">Hızlı Erişim</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Ana Sayfa</a></li>
                    <li><a href="{{ route('products.index') }}">Ürünlerimiz</a></li>
                    <li><a href="{{ route('about') }}">Hikayemiz</a></li>
                    <li><a href="{{ route('contact') }}">İletişim</a></li>
                </ul>
            </div>
            
            <div class="footer-links">
                <h4 class="footer-title">Kategoriler</h4>
                <ul>
                    @foreach(\App\Models\Category::all() as $cat)
                        <li><a href="{{ route('products.index', ['category' => $cat->slug]) }}">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            
            <div class="footer-contact">
                <h4 class="footer-title">İletişim Bilgileri</h4>
                <ul>
                    <li>
                        <span class="icon">📍</span>
                        <span>{{ \App\Models\Setting::getValue('contact_address', 'Antakya, Hatay, Türkiye') }}</span>
                    </li>
                    <li>
                        <span class="icon">📞</span>
                        <span>+{{ \App\Models\Setting::getValue('whatsapp_number', '905551234567') }}</span>
                    </li>
                    <li>
                        <span class="icon">✉️</span>
                        <span>{{ \App\Models\Setting::getValue('contact_email', 'bilgi@hataydogalsepet.com') }}</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="container footer-bottom">
            <p>&copy; {{ date('Y') }} {{ \App\Models\Setting::getValue('site_title', 'Hatay Doğal Sepet') }}. Tüm Hakları Saklıdır.</p>
            <p>
                <a href="{{ route('admin.login') }}" style="color: rgba(255, 255, 255, 0.4); text-decoration: underline;">
                    <i class="fa-solid fa-lock"></i> Yönetici Paneli
                </a>
            </p>
        </div>
    </footer>

    <!-- --- WHATSAPP SEPET DRAWER --- -->
    <div class="cart-drawer" id="cart-drawer">
        <div class="cart-drawer-header">
            <h3>Sipariş Sepetiniz</h3>
            <span class="cart-drawer-close" id="cart-close">✕</span>
        </div>
        <div class="cart-items-list" id="cart-items-list">
            <!-- Dinamik yüklenecek -->
            <div class="cart-empty-message">Sepetiniz şu anda boş.</div>
        </div>
        <div class="cart-drawer-footer">
            <div class="cart-total-row">
                <span>Toplam Tutar:</span>
                <span id="cart-total-amount">0.00 TL</span>
            </div>
            <button class="btn whatsapp-btn" id="whatsapp-order-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                WhatsApp ile Sipariş Ver
            </button>
        </div>
    </div>

    <!-- --- SCRIPTS --- -->
    <script src="{{ asset('js/main.js') }}"></script>
    @yield('scripts')
</body>
</html>
