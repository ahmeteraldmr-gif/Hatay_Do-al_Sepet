<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetici Girişi - {{ \App\Models\Setting::getValue('site_title', 'Hatay Doğal Sepet') }}</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    {{ explode(' ', \App\Models\Setting::getValue('site_title', 'Hatay Doğal Sepet'))[0] }}<span>{{ implode(' ', array_slice(explode(' ', \App\Models\Setting::getValue('site_title', 'Hatay Doğal Sepet')), 1)) }}</span>
                </div>
                <p>Yönetim Paneli Giriş Ekranı</p>
            </div>
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="list-style: none;">
                        @foreach($errors->all() as $error)
                            <li><i class="fa-solid fa-triangle-exclamation"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">E-Posta Adresi</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="admin@hataydogalsepet.com" required value="{{ old('email') }}">
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Şifre</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                </div>
                
                <div class="form-group" style="margin-top: 30px;">
                    <button type="submit" class="btn-primary" style="width: 100%; border: none; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 15px; background-color: var(--primary);">
                        Giriş Yap
                    </button>
                </div>
            </form>
            
            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ route('home') }}" style="font-size: 13px; color: var(--text-muted); text-decoration: underline;"><i class="fa-solid fa-arrow-left"></i> Siteye Geri Dön</a>
            </div>
        </div>
    </div>

</body>
</html>
