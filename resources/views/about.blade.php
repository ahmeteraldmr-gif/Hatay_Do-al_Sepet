@extends('layouts.app')

@section('title', 'Hikayemiz')

@section('content')

    <!-- --- PAGE BANNER --- -->
    <section class="page-banner banner-about" style="background-image: url('{{ asset('assets/banner_about.png') }}');">
        <div class="container text-center">
            <h1>Hikayemiz & Geleneklerimiz</h1>
            <p>Hatay'ın verimli topraklarından süzülen, binlerce yıllık sabun zanaatinin serüveni</p>
        </div>
    </section>

    <!-- --- MAIN STORY --- -->
    <section class="story-section section-padding" style="background-color: var(--color-white);">
        <div class="container story-grid">
            <div class="story-content">
                <span class="sub-accent">Toprağın Bereketi</span>
                <h2>Hatay'ın Kalbinden Gelen Şifa</h2>
                <p>Hatay, tarih boyunca zeytin ağaçlarının gölgesinde büyümüş, Akdeniz meltemleri ile yoğrulmuş kadim bir coğrafyadır. Bu topraklarda sabun yapmak sadece bir temizlik aracı üretmek değil; doğaya saygının, el emeğinin ve asırlık bir kültürün yaşatılmasıdır.</p>
                <p>{{ \App\Models\Setting::getValue('about_text', 'Hatay Doğal Sepet olarak amacımız, Hatay\'ın o dillere destan saf defne ve sızma zeytinyağlı sabunlarını, hiçbir endüstriyel fabrikasyona uğratmadan, en geleneksel haliyle banyolarınıza taşımaktır. Sabunlarımızın her birinde dedelerimizden miras kalan kazan kaynatma usulünü ve el emeğini koruyoruz.') }}</p>
                <p>Kimyasal koruyucular, yapay esanslar veya ucuz dolgu malzemeleri kullanmıyoruz. Sadece doğanın sunduğu şifayı, aslına sadık kalarak kalıplara döküyoruz.</p>
            </div>
            <div class="story-image-box">
                <img src="{{ asset('assets/about_production.png') }}" alt="Doğal Sabun Yapımı Hatay" class="story-img">
            </div>
        </div>
    </section>

    <!-- --- STEP-BY-STEP PROCESS --- -->
    <section class="process-section section-padding">
        <div class="container text-center">
            <h2 class="section-title">Sabunlarımızın Yapım Aşamaları</h2>
            <p class="section-subtitle">Tarladan kapınıza uzanan meşakkatli ve doğal üretim yolculuğu</p>

            <div class="process-timeline">
                <!-- Adım 1 -->
                <div class="process-step">
                    <div class="step-number">01</div>
                    <div class="step-info">
                        <h3>Hasat ve Sıkım</h3>
                        <p>Sonbahar aylarında Hatay'ın yerli zeytinlerini ve dağlarda yetişen yabani defne meyvelerini (gar) özenle topluyoruz. Zeytinleri soğuk sıkım yöntemiyle sıkıp sızma zeytinyağı elde ederken, defne meyvelerini de kaynatarak meşhur defne yağını süzüyoruz.</p>
                    </div>
                </div>

                <!-- Adım 2 -->
                <div class="process-step">
                    <div class="step-number">02</div>
                    <div class="step-info">
                        <h3>Kazanlarda Kaynatma</h3>
                        <p>Elde ettiğimiz yağları dev bakır kazanlara aktarıyoruz. Odun ateşinde, Hatay'a has geleneksel alkali kaynak (meşe odunu külü suyu) yardımıyla saatlerce kaynatıyoruz. Sabunlaşma tamamlandığında karışım yoğun bir kıvama ulaşır.</p>
                    </div>
                </div>

                <!-- Adım 3 -->
                <div class="process-step">
                    <div class="step-number">03</div>
                    <div class="step-info">
                        <h3>Kalıplara Döküm ve Kesim</h3>
                        <p>Kaynayan sabun harcını düz zeminlere serilmiş bezlerin üzerine döküyoruz. Düzleştirilen sabun tabakası hafifçe sertleştiğinde, ustalarımız tarafından özel bıçaklarla geleneksel kare kalıplar halinde elle kesilir ve üzerine mühür basılır.</p>
                    </div>
                </div>

                <!-- Adım 4 -->
                <div class="process-step">
                    <div class="step-number">04</div>
                    <div class="step-info">
                        <h3>Kurutma (En Az 9 Ay)</h3>
                        <p>Kesilen sabun bloklarını hava sirkülasyonu sağlayacak şekilde kuleler halinde üst üste diziyoruz. Hatay'ın kuru rüzgarlarında, loş depolarda en az 9 ay boyunca kurumaya bırakıyoruz. Kurudukça yeşil rengi dıştan içe doğru tatlı bir krem rengine döner.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
