@extends('layouts.admin')

@section('title', 'Yönetim Paneli')

@section('content')

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3>Toplam Ürün</h3>
                <p>{{ \App\Models\Product::count() }}</p>
            </div>
            <div class="stat-icon">
                <i class="fa-solid fa-soap"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h3>Toplam Kategori</h3>
                <p>{{ \App\Models\Category::count() }}</p>
            </div>
            <div class="stat-icon">
                <i class="fa-solid fa-tags"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3>Okunmamış Mesajlar</h3>
                <p>{{ \App\Models\Message::where('is_read', false)->count() }}</p>
            </div>
            <div class="stat-icon" style="background-color: rgba(239, 68, 68, 0.1); color: #EF4444;">
                <i class="fa-solid fa-envelope"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h3>WhatsApp Sipariş Hattı</h3>
                <p style="font-size: 18px; margin-top: 10px;">+{{ \App\Models\Setting::getValue('whatsapp_number', '905551234567') }}</p>
            </div>
            <div class="stat-icon" style="background-color: rgba(37, 211, 102, 0.1); color: #25D366;">
                <i class="fa-brands fa-whatsapp"></i>
            </div>
        </div>
    </div>

    <div class="table-card" style="padding: 24px;">
        <h3 style="margin-bottom: 20px; font-size: 16px; font-weight: 600;"><i class="fa-solid fa-compass"></i> Hızlı Başlangıç Kılavuzu</h3>
        <p style="font-size: 14px; color: var(--text-muted); margin-bottom: 16px; line-height: 1.6;">
            Hatay Doğal Sepet kontrol paneline hoş geldiniz. Burası e-ticaret sitenizin kataloğunu ve bilgilerini yöneteceğiniz alandır.
        </p>
        <div style="display: flex; gap: 16px; flex-wrap: wrap;">
            <a href="{{ route('admin.products', ['create' => 1]) }}" class="btn-primary" style="padding: 10px 20px; text-decoration: none; border-radius: 8px; font-size: 14px; font-weight: 500; background-color: var(--primary); color: white;">
                <i class="fa-solid fa-circle-plus"></i> Yeni Sabun Ekle
            </a>
            <a href="{{ route('admin.settings') }}" class="btn-primary" style="padding: 10px 20px; text-decoration: none; border-radius: 8px; font-size: 14px; font-weight: 500; background-color: var(--accent); color: white;">
                <i class="fa-solid fa-phone"></i> WhatsApp No Güncelle
            </a>
            <a href="{{ route('home') }}" target="_blank" class="btn-primary" style="padding: 10px 20px; text-decoration: none; border-radius: 8px; font-size: 14px; font-weight: 500; background-color: var(--sidebar-bg); color: white;">
                <i class="fa-solid fa-eye"></i> Ön Yüzü Görüntüle
            </a>
        </div>
    </div>

@endsection
