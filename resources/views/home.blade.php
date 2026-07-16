@extends('layouts.app')

@section('title', 'Geleneksel ve Doğal Sabunlar')

@section('content')

    <!-- --- HERO SECTION --- -->
    <section class="hero">
        <div class="hero-bg" style="background-image: url('{{ asset('assets/hero.png') }}');"></div>
        <div class="hero-content container">
            <span class="hero-tag">{{ \App\Models\Setting::getValue('site_tagline', 'Hatay\'ın Asırlık Mucizesi') }}</span>
            <h1>{{ \App\Models\Setting::getValue('hero_title', 'Doğanın Evinize En Saf Dokunuşu') }}</h1>
            <p>{{ \App\Models\Setting::getValue('hero_subtitle', 'Geleneksel yöntemlerle, el emeğiyle hazırlanan saf defne ve sızma zeytinyağlı sabunlar ile cildinizi doğanın kucağına bırakın.') }}</p>
            <div class="hero-actions">
                <a href="{{ route('products.index') }}" class="btn btn-accent">Alışverişe Başla</a>
                <a href="{{ route('about') }}" class="btn btn-secondary hero-btn-sec">Hikayemiz</a>
            </div>
        </div>
    </section>

    <!-- --- VALUES SECTION --- -->
    <section class="values-section section-padding">
        <div class="container text-center">
            <h2 class="section-title">Hatay Doğal Sepet Farkı</h2>
            <p class="section-subtitle">Sabunlarımızın neden bu kadar özel olduğunu keşfedin</p>
            
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <h3>%100 Doğal İçerik</h3>
                    <p>Hiçbir kimyasal katkı maddesi, paraben, yapay renklendirici veya hayvansal yağ içermez. Sadece saf zeytinyağı ve bitki özleri.</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    </div>
                    <h3>Asırlık Gelenek</h3>
                    <p>Hatay'ın kuşaktan kuşağa aktarılan geleneksel kazan kaynatma ve soğuk kesim teknikleriyle sabunun özünü koruyoruz.</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/><path d="M2 12h20"/></svg>
                    </div>
                    <h3>Coğrafi İşaretli Zeytinler</h3>
                    <p>Sabunlarımızın temelini Hatay'ın verimli topraklarında yetişen, asit oranı düşük ve şifalı sızma zeytinyağları oluşturur.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- --- FEATURED PRODUCTS --- -->
    <section class="featured-products section-padding" style="background-color: var(--color-white);">
        <div class="container text-center">
            <h2 class="section-title">Öne Çıkan Sabunlarımız</h2>
            <p class="section-subtitle">En çok tercih edilen, cildinize sağlık katacak özel sabun çeşitlerimiz</p>
            
            <div class="products-grid">
                @foreach(\App\Models\Product::with('category')->orderBy('name', 'asc')->take(3)->get() as $product)
                    <div class="product-card">
                        @if($product->in_stock)
                            <div class="product-badge">Öne Çıkan</div>
                        @else
                            <div class="product-badge" style="background-color: #EF4444;">Tükendi</div>
                        @endif
                        <a href="{{ route('products.show', $product->slug) }}" class="product-img-wrapper" style="display: block;">
                            @if($product->image_path)
                                <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="product-img">
                            @else
                                <div style="width: 100%; height: 260px; background-color: var(--color-primary-light); color: white; display: flex; align-items: center; justify-content: center; font-size: 40px; font-weight: bold;">
                                    {{ mb_substr($product->name, 0, 1) }}
                                </div>
                            @endif
                        </a>
                        <div class="product-details">
                            <h3 class="product-name">
                                <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <p class="product-desc">{{ Str::limit($product->description, 100) }}</p>
                            
                            <div class="product-features">
                                @php
                                    $benefits = array_filter(array_map('trim', explode('.', $product->benefits)));
                                @endphp
                                @if(!empty($benefits))
                                    @foreach(array_slice($benefits, 0, 3) as $benefit)
                                        <span>🌿 {{ $benefit }}</span>
                                    @endforeach
                                @else
                                    <span>🌿 %100 El Yapımı</span>
                                    <span>🌿 Doğal Ham Maddeler</span>
                                    <span>🌿 Katkısız Üretim</span>
                                @endif
                            </div>
                            
                            <div class="product-footer">
                                <span class="product-price">{{ number_format($product->price, 2) }} TL</span>
                                @if($product->in_stock)
                                    <button class="btn btn-primary btn-sm" onclick="addToCart('p-{{ $product->id }}', '{{ $product->name }}', '{{ $product->price }}', '{{ asset($product->image_path) }}')">Sepete Ekle</button>
                                @else
                                    <button class="btn btn-secondary btn-sm" style="cursor: not-allowed; opacity: 0.6;" disabled>Tükendi</button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div style="margin-top: 50px;">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Tüm Sabunları Keşfet</a>
            </div>
        </div>
    </section>

    <!-- --- ABOUT PREVIEW SECTION (0'DAN YAPIM SÜRECİ) --- -->
    <section class="about-preview section-padding">
        <div class="container">
            <div class="text-center">
                <span class="sub-accent">Asırlık Zanaat</span>
                <h2 class="section-title">0'dan Geleneksel Sabun Yapımı</h2>
                <p class="section-subtitle">Hatay sabununun hiçbir kimyasal katkı maddesi kullanılmadan, tamamen doğal ham maddelerle elde edilme süreci</p>
            </div>
            
            <div class="making-steps-grid">
                <!-- Adım 1 -->
                <div class="step-card">
                    <div class="step-badge">1</div>
                    <h3>Yağların Sıkılması</h3>
                    <p>Ekim-Kasım aylarında Hatay zeytinleri soğuk sıkımla zeytinyağına dönüştürülür. Yabani defne meyveleri ise kaynatılıp süzülerek şifalı defne yağı elde edilir.</p>
                </div>
                
                <!-- Adım 2 -->
                <div class="step-card">
                    <div class="step-badge">2</div>
                    <h3>Doğal Kül Suyu Hazırlığı</h3>
                    <p>Kimyasal kostik yerine meşe odunlarının külleri toplanır, temiz suyla kaynatılıp süzülür. Yağları sabuna dönüştürecek doğal alkali su elde edilir.</p>
                </div>
                
                <!-- Adım 3 -->
                <div class="step-card">
                    <div class="step-badge">3</div>
                    <h3>Kazanlarda Kaynatma</h3>
                    <p>Zeytinyağı ve defne yağı dev bakır kazanlara alınır. Odun ateşinde yavaşça kül suyu eklenerek 12 saat boyunca sürekli karıştırılarak kaynatılır.</p>
                </div>
                
                <!-- Adım 4 -->
                <div class="step-card">
                    <div class="step-badge">4</div>
                    <h3>Kalıplama & Kesim</h3>
                    <p>Kıvam alan sabun harcı bez serili zeminlere dökülür. Hafifçe sertleşince ustalar geleneksel bıçaklarla elle kesip mühürler.</p>
                </div>
                
                <!-- Adım 5 -->
                <div class="step-card">
                    <div class="step-badge">5</div>
                    <h3>Doğal Kurutma</h3>
                    <p>Kare sabun kalıpları hava alacak şekilde kuleler halinde dizilir. En az 9 ay boyunca Hatay'ın kuru rüzgarlarında kurumaya bırakılır.</p>
                </div>
            </div>
            
            <div class="text-center" style="margin-top: 50px;">
                <a href="{{ route('about') }}" class="btn btn-primary">Tüm Hikayemizi Oku</a>
            </div>
        </div>
    </section>

    <!-- --- TESTIMONIALS SECTION --- -->
    <section class="testimonials section-padding" style="background-color: var(--color-white);">
        <div class="container text-center">
            <h2 class="section-title">Müşterilerimizin Yorumları</h2>
            <p class="section-subtitle">Doğallıkla tanışanların gerçek deneyimleri</p>
            
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <p class="testimonial-text">"Egzama problemim için denemediğim krem kalmamıştı. Defne sabununuzu kullanmaya başladığımdan beri cildim yatıştı ve kaşıntım tamamen geçti. Çok teşekkür ederim."</p>
                    <h4 class="testimonial-author">Ayşe Yılmaz</h4>
                    <span class="testimonial-location">İstanbul</span>
                </div>
                
                <div class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <p class="testimonial-text">"Zeytinyağlı sabunu bebeğim için kullanıyorum. Cildini hiç kurutmadı ve kokusu o kadar temiz ki. Doğal ve güvenilir bir ürün bulduğum için çok mutluyum."</p>
                    <h4 class="testimonial-author">Mehmet Demir</h4>
                    <span class="testimonial-location">Ankara</span>
                </div>
                
                <div class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <p class="testimonial-text">"Lavanta sabununu banyoda kullanıyorum. Tüm banyo mis gibi lavanta kokuyor. Hem cildi yumuşatıyor hem de günün yorgunluğunu alıyor. Kesinlikle tavsiye ederim."</p>
                    <h4 class="testimonial-author">Elif Kaya</h4>
                    <span class="testimonial-location">İzmir</span>
                </div>
            </div>
        </div>
    </section>

@endsection
