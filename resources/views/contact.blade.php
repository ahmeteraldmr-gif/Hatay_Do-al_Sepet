@extends('layouts.app')

@section('title', 'İletişim')
@section('meta_description', 'Hatay Doğal Sepet iletişim sayfası. Doğal sabun siparişleriniz ve sorularınız için bizimle iletişime geçin.')

@section('content')

    <!-- --- PAGE BANNER --- -->
    <section class="page-banner banner-contact" style="background-image: url('{{ asset('assets/banner_contact.png') }}');">
        <div class="container text-center">
            <h1>Bizimle İletişime Geçin</h1>
            <p>Ürünlerimiz hakkında merak ettikleriniz, toptan sipariş talepleriniz ve iş ortaklığı için bize ulaşabilirsiniz</p>
        </div>
    </section>

    <!-- --- CONTACT CONTENT --- -->
    <section class="contact-section section-padding" style="background-color: var(--color-white);">
        <div class="container contact-grid">
            
            <!-- İletişim Formu -->
            <div class="contact-form-box">
                <h2>Mesaj Gönderin</h2>
                <p>Aşağıdaki formu doldurarak bize her türlü soru, görüş ve önerinizi iletebilirsiniz. En kısa sürede geri dönüş sağlayacağız.</p>
                
                @if(session('contact_success'))
                    <div class="alert alert-success" style="margin-bottom: 20px;">
                        <i class="fa-solid fa-circle-check"></i> {{ session('contact_success') }}
                    </div>
                @endif
                
                <form action="{{ route('contact.submit') }}" method="POST" class="contact-form" id="contact-form">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Adınız Soyadınız</label>
                            <input type="text" name="name" id="name" required placeholder="Örn: Ahmet Yılmaz" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="email">E-Posta Adresiniz</label>
                            <input type="email" name="email" id="email" required placeholder="name@domain.com" value="{{ old('email') }}">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Konu</label>
                        <input type="text" name="subject" id="subject" required placeholder="Neyle ilgili görüşmek istersiniz?" value="{{ old('subject') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Mesajınız</label>
                        <textarea name="message" id="message" rows="6" required placeholder="Mesajınızı buraya yazınız...">{{ old('message') }}</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Gönder</button>
                </form>
            </div>
            
            <!-- İletişim Bilgileri -->
            <div class="contact-info-box">
                <h2>İletişim Kanallarımız</h2>
                <p>Doğrudan arayabilir, e-posta gönderebilir veya WhatsApp hattımız üzerinden anlık olarak bilgi alabilirsiniz.</p>
                
                <div class="info-details">
                    <div class="info-item">
                        <span class="info-icon">📍</span>
                        <div class="info-text">
                            <h3>Adresimiz</h3>
                            <p>{{ \App\Models\Setting::getValue('contact_address', 'Antakya, Hatay, Türkiye') }}</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <span class="info-icon">📞</span>
                        <div class="info-text">
                            <h3>Telefon / WhatsApp</h3>
                            <p>+{{ \App\Models\Setting::getValue('whatsapp_number', '905551234567') }}</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <span class="info-icon">✉️</span>
                        <div class="info-text">
                            <h3>E-Posta</h3>
                            <p>{{ \App\Models\Setting::getValue('contact_email', 'bilgi@hataydogalsepet.com') }}</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <span class="info-icon">🕒</span>
                        <div class="info-text">
                            <h3>Çalışma Saatleri</h3>
                            <p>Pazartesi - Cumartesi: 09:00 - 19:00<br>Pazar: Kapalı</p>
                        </div>
                    </div>
                </div>

                <div class="contact-cta">
                    <h3>Hızlı Sipariş & Bilgi</h3>
                    <p>Siparişlerinizi WhatsApp üzerinden de hızlıca oluşturabilirsiniz.</p>
                    <a href="https://wa.me/{{ \App\Models\Setting::getValue('whatsapp_number', '905551234567') }}" target="_blank" class="btn whatsapp-btn" style="display: inline-flex; width: auto; max-width: 250px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                        WhatsApp Destek Hattı
                    </a>
                </div>
            </div>

        </div>
    </section>

@endsection
