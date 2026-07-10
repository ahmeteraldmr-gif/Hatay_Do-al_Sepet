@extends('layouts.admin')

@section('title', 'Site Ayarları')

@section('content')

    <div class="table-card" style="padding: 24px;">
        <div class="table-header" style="border-bottom: none; padding: 0 0 20px 0;">
            <h3 class="table-title"><i class="fa-solid fa-sliders"></i> Dinamik Site Ayarları</h3>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            
            <h4 style="margin: 20px 0 10px 0; color: var(--primary); border-bottom: 2px solid rgba(74, 93, 78, 0.1); padding-bottom: 6px;">
                <i class="fa-solid fa-circle-info"></i> Genel Bilgiler
            </h4>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="site_title" class="form-label">Site Başlığı *</label>
                    <input type="text" name="site_title" id="site_title" class="form-control" value="{{ old('site_title', \App\Models\Setting::getValue('site_title')) }}" required>
                </div>

                <div class="form-group">
                    <label for="site_tagline" class="form-label">Slogan / Kısa Tanıtım *</label>
                    <input type="text" name="site_tagline" id="site_tagline" class="form-control" value="{{ old('site_tagline', \App\Models\Setting::getValue('site_tagline')) }}" required>
                </div>
            </div>

            <h4 style="margin: 30px 0 10px 0; color: var(--primary); border-bottom: 2px solid rgba(74, 93, 78, 0.1); padding-bottom: 6px;">
                <i class="fa-solid fa-paper-plane"></i> İletişim & Sipariş
            </h4>

            <div class="form-grid">
                <div class="form-group">
                    <label for="whatsapp_number" class="form-label">WhatsApp Sipariş Numarası * (Ülke kodu dahil, boşluksuz yazın)</label>
                    <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control" placeholder="Örn: 905551234567" value="{{ old('whatsapp_number', \App\Models\Setting::getValue('whatsapp_number')) }}" required>
                    <span style="font-size: 11px; color: var(--text-muted);">
                        Başına sıfır koymadan ülke koduyla yazın. (Türkiye için 90 ile başlamalıdır).
                    </span>
                </div>

                <div class="form-group">
                    <label for="contact_email" class="form-label">İletişim E-Posta Adresi</label>
                    <input type="email" name="contact_email" id="contact_email" class="form-control" value="{{ old('contact_email', \App\Models\Setting::getValue('contact_email')) }}">
                </div>
            </div>

            <div class="form-group">
                <label for="contact_address" class="form-label">İletişim Adresi</label>
                <input type="text" name="contact_address" id="contact_address" class="form-control" value="{{ old('contact_address', \App\Models\Setting::getValue('contact_address')) }}">
            </div>

            <h4 style="margin: 30px 0 10px 0; color: var(--primary); border-bottom: 2px solid rgba(74, 93, 78, 0.1); padding-bottom: 6px;">
                <i class="fa-solid fa-window-maximize"></i> Ana Sayfa Hero (Karşılama) Alanı
            </h4>

            <div class="form-group">
                <label for="hero_title" class="form-label">Karşılama Başlığı *</label>
                <input type="text" name="hero_title" id="hero_title" class="form-control" value="{{ old('hero_title', \App\Models\Setting::getValue('hero_title')) }}" required>
            </div>

            <div class="form-group">
                <label for="hero_subtitle" class="form-label">Karşılama Alt Metni *</label>
                <textarea name="hero_subtitle" id="hero_subtitle" class="form-control" rows="3" required>{{ old('hero_subtitle', \App\Models\Setting::getValue('hero_subtitle')) }}</textarea>
            </div>

            <h4 style="margin: 30px 0 10px 0; color: var(--primary); border-bottom: 2px solid rgba(74, 93, 78, 0.1); padding-bottom: 6px;">
                <i class="fa-solid fa-address-card"></i> Hakkımızda Metni
            </h4>

            <div class="form-group">
                <label for="about_text" class="form-label">Hakkımızda Detay Metni *</label>
                <textarea name="about_text" id="about_text" class="form-control" rows="6" required>{{ old('about_text', \App\Models\Setting::getValue('about_text')) }}</textarea>
            </div>

            <div style="margin-top: 40px; border-top: 1px solid var(--border); padding-top: 20px;">
                <button type="submit" class="btn-primary" style="border: none; padding: 12px 35px; border-radius: 8px; font-weight: 600; cursor: pointer; background-color: var(--primary); color: white;">
                    <i class="fa-solid fa-floppy-disk"></i> Tüm Ayarları Kaydet
                </button>
            </div>
            
        </form>
    </div>

@endsection
