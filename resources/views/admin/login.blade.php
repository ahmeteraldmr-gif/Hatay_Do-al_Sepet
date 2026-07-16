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
                    🌿 {{ explode(' ', \App\Models\Setting::getValue('site_title', 'Hatay Doğal Sepet'))[0] }}<span>{{ implode(' ', array_slice(explode(' ', \App\Models\Setting::getValue('site_title', 'Hatay Doğal Sepet')), 1)) }}</span>
                </div>
                <p>Yönetim Paneli Giriş Ekranı</p>
            </div>
            
            @if($errors->any())
                <div class="alert alert-danger" style="background-color: #FEF2F2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 13.5px;">
                    <ul style="list-style: none; margin: 0; padding: 0;">
                        @foreach($errors->all() as $error)
                            <li><i class="fa-solid fa-triangle-exclamation" style="margin-right: 6px;"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">E-Posta Adresi</label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-envelope input-icon"></i>
                        <input type="email" name="email" id="email" class="form-control" placeholder="admin@hataydogalsepet.com" required value="{{ old('email') }}">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Şifre</label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>
                
                <div class="form-group" style="margin-top: 30px;">
                    <button type="submit" class="btn-login">
                        Giriş Yap <i class="fa-solid fa-right-to-bracket" style="margin-left: 6px;"></i>
                    </button>
                </div>
            </form>
            
            <div style="text-align: center; margin-top: 25px;">
                <a href="{{ route('home') }}" style="font-size: 13.5px; color: var(--text-muted); text-decoration: none; font-weight: 500; transition: var(--transition);" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'"><i class="fa-solid fa-arrow-left" style="margin-right: 4px;"></i> Siteye Geri Dön</a>
            </div>
        </div>
    </div>

</body>
</html>
