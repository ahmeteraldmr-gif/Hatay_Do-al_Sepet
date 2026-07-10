<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Yönetici Paneli</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('styles')
</head>
<body>

    <div class="admin-layout">
        
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <i class="fa-solid fa-leaf"></i> 
                {{ explode(' ', \App\Models\Setting::getValue('site_title', 'Hatay Doğal Sepet'))[0] }}<span>Panel</span>
            </div>
            
            <ul class="sidebar-menu">
                <li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fa-solid fa-chart-line"></i> Dashboard
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                    <a href="{{ route('admin.products') }}">
                        <i class="fa-solid fa-soap"></i> Ürün Yönetimi
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                    <a href="{{ route('admin.categories') }}">
                        <i class="fa-solid fa-tags"></i> Kategori Yönetimi
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
                    <a href="{{ route('admin.messages') }}" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                        <span><i class="fa-solid fa-envelope"></i> Gelen Mesajlar</span>
                        @php
                            $unreadCount = \App\Models\Message::where('is_read', false)->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span style="background-color: #EF4444; color: white; padding: 2px 8px; border-radius: 20px; font-size: 11px; font-weight: 700; margin-left: 5px;">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings') }}">
                        <i class="fa-solid fa-gears"></i> Site Ayarları
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('home') }}" target="_blank">
                        <i class="fa-solid fa-globe"></i> Siteyi Görüntüle
                    </a>
                </li>
            </ul>
            
            <div class="sidebar-footer">
                <li class="sidebar-item" style="list-style: none;">
                    <a href="{{ route('admin.logout') }}" style="color: #F87171;">
                        <i class="fa-solid fa-right-from-bracket"></i> Çıkış Yap
                    </a>
                </li>
            </div>
        </aside>
        
        <!-- Main Content Wrapper -->
        <div class="admin-main">
            <!-- Top Header -->
            <header class="admin-header">
                <div>
                    <h2 style="font-size: 20px; font-weight: 600;">@yield('title')</h2>
                </div>
                <div class="admin-user">
                    <i class="fa-regular fa-circle-user" style="font-size: 20px;"></i>
                    <span>{{ Auth::user()->name }}</span>
                </div>
            </header>
            
            <!-- Dashboard Content -->
            <main class="admin-content">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
        
    </div>

    @yield('scripts')
</body>
</html>
