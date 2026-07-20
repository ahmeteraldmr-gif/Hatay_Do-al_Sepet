<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User
        User::updateOrCreate(
            ['email' => 'admin@hataydogalsepet.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Seed Settings
        $settings = [
            'site_title' => 'Hatay Doğal Sepet',
            'site_tagline' => 'Hatay\'ın Asırlık Mucizesi',
            'whatsapp_number' => '905427352994',
            'contact_address' => 'Kurtuluş Caddesi, No: 42, Antakya, Hatay, Türkiye',
            'contact_email' => 'bilgi@hataydogalsepet.com',
            'about_text' => 'Hatay Doğal Sepet olarak amacımız, Hatay\'ın o dillere destan saf defne ve sızma zeytinyağlı sabunlarını, hiçbir endüstriyel fabrikasyona uğratmadan, en geleneksel haliyle banyolarınıza taşımaktır. Sabunlarımızın her birinde dedelerimizden miras kalan kazan kaynatma usulünü ve el emeğini koruyoruz. Kimyasal koruyucular, yapay esanslar veya ucuz dolgu malzemeleri kullanmıyoruz. Sadece doğanın sunduğu şifayı, aslına sadık kalarak kalıplara döküyoruz.',
            'hero_title' => 'Doğanın Evinize En Saf Dokunuşu',
            'hero_subtitle' => 'Geleneksel yöntemlerle, el emeğiyle hazırlanan saf defne ve sızma zeytinyağlı sabunlar ile cildinizi doğanın kucağına bırakın.',
        ];

        foreach ($settings as $key => $value) {
            Setting::setValue($key, $value);
        }

        // 3. Seed Categories
        $catDefne = Category::updateOrCreate(
            ['slug' => 'defne-sabunlari'],
            [
                'name' => 'Defne Sabunları', 
                'emoji' => '🍃', 
                'description' => 'Yabani defne ağacı yağı ile zeytinyağının birleşimi. Saç ve cilt şifası.',
                'seo_title' => 'Hakiki Hatay Defne Sabunları | El Yapımı Defne Sabunu',
                'seo_description' => 'Hatay\'ın meşhur yabani defne meyvesi yağı ve saf soğuk sıkım zeytinyağı ile hazırlanan geleneksel el yapımı defne sabunlarımızı keşfedin.',
                'og_title' => 'Hatay\'ın Şifalı El Yapımı Defne Sabunları',
                'og_description' => 'Saç ve cilt döküntüleri, egzama ve kepeğe karşı etkili asırlık Hatay defne sabunları.',
                'noindex' => false
            ]
        );

        $catZeytin = Category::updateOrCreate(
            ['slug' => 'zeytinyagi-sabunlari'],
            [
                'name' => 'Zeytinyağı Sabunları', 
                'emoji' => '🫒', 
                'description' => '%100 saf Hatay zeytinyağından üretilen, cildi kurutmayan besleyici sabunlar.',
                'seo_title' => 'Saf Zeytinyağlı Sabun Çeşitleri | %100 Doğal Hatay Sabunu',
                'seo_description' => '%100 saf sızma zeytinyağından odun ateşinde üretilen, cildinizi kurutmadan nemlendiren geleneksel Hatay zeytinyağlı sabunları.',
                'og_title' => '%100 Saf Soğuk Sıkım Zeytinyağlı Sabunlar',
                'og_description' => 'Kimyasal katkısız, bebek cildine dahi uygun besleyici ve nemlendirici zeytinyağı sabunu.',
                'noindex' => false
            ]
        );

        $catOzel = Category::updateOrCreate(
            ['slug' => 'bitkisel-ve-kokulu-sabunlar'],
            [
                'name' => 'Aromaterapi Serisi', 
                'emoji' => '🌸', 
                'description' => 'Bitkisel özler ve doğal uçucu yağlarla zenginleştirilmiş özel kokulu sabunlar.',
                'seo_title' => 'Doğal Aromaterapi Sabunları & Bitkisel Özlü Sabun',
                'seo_description' => 'Lavanta, kekik, aloe vera gibi şifalı bitkilerin uçucu yağları ve bitki özleriyle zenginleştirilmiş aromaterapi el yapımı sabun serimiz.',
                'og_title' => 'Aromaterapi ve Bitkisel El Yapımı Sabun Serisi',
                'og_description' => 'Bitkisel yağlar ve özlerle zenginleştirilmiş şifalı aromaterapi sabunlarımız.',
                'noindex' => false
            ]
        );

        $catKampanya = Category::updateOrCreate(
            ['slug' => 'kampanyalar'],
            [
                'name' => 'Kampanyalar', 
                'emoji' => '🎁', 
                'description' => 'Özel indirimli doğal setler ve dönemsel kampanyalı ürünlerimiz.',
                'seo_title' => 'İndirimli Doğal Bakım Setleri | Hatay Doğal Sepet Kampanyaları',
                'seo_description' => 'Doğal zeytinyağlı şampuanlar, el yapımı sabunlar ve cilt bakım ürünlerini bir arada sunan avantajlı hediye setleri ve kampanyalar.',
                'og_title' => 'Avantajlı Doğal Bakım Hediye Setleri & Kampanyalar',
                'og_description' => 'Komple saç ve cilt bakımı sunan %100 doğal içerikli hediye setlerinde özel indirimler.',
                'noindex' => false
            ]
        );

        // Delete all existing products first to clean up old photos
        Product::query()->delete();

        // 4. Seed Products (Alphabetically ordered by name)
        $products = [
            [
                'category_id' => $catOzel->id,
                'name' => 'M. Çakır Can - Doğal Cilt Bakım Ürünü',
                'slug' => 'm-cakir-can-dogal-cilt-bakim-urunu',
                'description' => 'Doğal bitki özleriyle cildinize ipeksi bir dokunuş sağlayan, nem dengesini koruyan ve tazeleyen cilt bakım ürünü.',
                'ingredients' => 'Doğal aloe vera özü, bitkisel nemlendiriciler, gliserin.',
                'benefits' => 'Cildin nem dengesini korur. Aloe vera özüyle cildi ferahlatır. İpeksi bir yumuşaklık sağlar.',
                'usage' => 'Temiz cilde dairesel hareketlerle masaj yaparak uygulayın.',
                'price' => 250.00,
                'image_path' => 'assets/cilt_bakim_kremi.jpg',
                'in_stock' => true,
                'seo_title' => 'M. Çakır Can Doğal Cilt Bakım Kremi | Nemlendirici Aloe Vera',
                'seo_description' => 'Aloe vera özü ve bitkisel nemlendiriciler içeren, cildi derinlemesine besleyen ve ipeksi yumuşaklık veren el yapımı cilt bakım kremi.',
                'og_title' => 'M. Çakır Can Bitkisel & Doğal Cilt Bakım Kremi',
                'og_description' => 'Cildin nem dengesini koruyan ve tazeleyen aloe veralı doğal cilt bakım kremi.',
                'og_image' => null,
                'noindex' => false
            ],
            [
                'category_id' => $catKampanya->id,
                'name' => 'M. Çakır Can - Doğal Güzellik Seti',
                'slug' => 'm-cakir-can-dogal-guzellik-seti',
                'description' => 'M. Çakır Can el yapımı zeytinyağı sabunu, doğal cilt bakım kremi, bitkisel saç bakım yağı ve el yapımı şampuandan oluşan, kargo dahil avantajlı fiyata sahip özel bakım seti.',
                'ingredients' => 'Doğal sabun, cilt bakım kremi, saç bakım yağı, zeytinyağlı şampuan.',
                'benefits' => 'Ücretsiz Kargo. Komple Saç ve Cilt Bakımı. %100 Doğal İçerikli Özel Avantajlı Set.',
                'usage' => 'Ürünlerin üzerinde belirtilen günlük kullanım talimatlarına göre uygulayınız.',
                'price' => 1000.00,
                'image_path' => 'assets/guzellik_seti.jpg',
                'in_stock' => true,
                'seo_title' => 'M. Çakır Can Doğal Güzellik Seti | Ücretsiz Kargo Avantajlı Paket',
                'seo_description' => 'El yapımı sabun, şampuan, cilt bakım kremi ve saç bakım yağından oluşan, komple doğal bakım sunan ücretsiz kargolu avantajlı hediye seti.',
                'og_title' => 'M. Çakır Can - Komple Geleneksel Güzellik ve Bakım Seti',
                'og_description' => 'Kargo dahil 1000 TL avantajlı fiyatıyla komple saç ve cilt bakımı sunan özel doğal sepet seti.',
                'og_image' => null,
                'noindex' => false
            ],
            [
                'category_id' => $catZeytin->id,
                'name' => 'M. Çakır Can - El Yapımı Lavanta & Aloe Vera Şampuanı',
                'slug' => 'm-cakir-can-el-yapimi-lavanta-aloe-vera-sampuani',
                'description' => 'Zeytinyağı tabanlı, saf bitki özleri içeren cilde dost el yapımı lavanta ve aloe vera şampuanı.',
                'ingredients' => 'Saf zeytinyağı, lavanta özü, aloe vera jeli, doğal şampuan bazı.',
                'benefits' => 'Zeytinyağı tabanlı formül. Saf lavanta ve aloe vera özleri. Cilde ve saç derisine dost temizlik.',
                'usage' => 'Islak saça köpürterek uygulayın, durulayın.',
                'price' => 300.00,
                'image_path' => 'assets/lavanta_sampuan.jpg',
                'in_stock' => true,
                'seo_title' => 'M. Çakır Can El Yapımı Lavanta & Aloe Vera Şampuanı',
                'seo_description' => 'Zeytinyağı tabanlı, saf lavanta ve aloe vera jeli ile el yapımı, saç derisini yatıştıran ve dökülmeyi önleyen şampuan.',
                'og_title' => 'Lavanta & Aloe Vera Özlü El Yapımı Doğal Şampuan',
                'og_description' => 'Zeytinyağı tabanlı doğal formülü ve lavanta kokusuyla saç derisine dost temizlik.',
                'og_image' => null,
                'noindex' => false
            ],
            [
                'category_id' => $catZeytin->id,
                'name' => 'M. Çakır Can - El Yapımı Yeşil Elma & Aloe Vera Şampuani',
                'slug' => 'm-cakir-can-el-yapimi-yesil-elma-aloe-vera-sampuani',
                'description' => 'Yeşil elma ve aloe vera özleriyle zenginleştirilmiş, zeytinyağı tabanlı doğal el yapımı şampuan.',
                'ingredients' => 'Saf zeytinyağı, yeşil elma özü, aloe vera jeli, bitkisel temizleyiciler.',
                'benefits' => 'Doğal elma aromasıyla ferahlık. Zeytinyağı ile saçları besler. %100 el yapımı ve cilde dost.',
                'usage' => 'Islak saça köpürterek uygulayın, durulayın.',
                'price' => 300.00,
                'image_path' => 'assets/elma_sampuan.jpg',
                'in_stock' => true,
                'seo_title' => 'M. Çakır Can El Yapımı Yeşil Elma & Aloe Vera Şampuanı',
                'seo_description' => 'Zeytinyağı tabanlı, doğal yeşil elma aromalı ve aloe vera özlü saçları besleyen ve parlaklık veren el yapımı şampuan.',
                'og_title' => 'Yeşil Elma & Aloe Vera Özlü El Yapımı Doğal Şampuan',
                'og_description' => 'Yeşil elmanın canlandırıcı ferahlığı ve zeytinyağının besleyici gücü saçlarınızda.',
                'og_image' => null,
                'noindex' => false
            ],
            [
                'category_id' => $catKampanya->id,
                'name' => 'M. Çakır Can - Özel İkili Bakım Seti',
                'slug' => 'm-cakir-can-ozel-ikili-bakim-seti',
                'description' => 'M. Çakır Can el yapımı zeytinyağı tabanlı Lavanta & Aloe Vera Şampuanı ve saf bitki özlü Saç Bakım Ürünü\'nden oluşan, Dörtyol Hatay üretimi özel ikili bakım seti.',
                'ingredients' => 'Lavanta & Aloe Vera Şampuanı (Saf zeytinyağı, lavanta özü, aloe vera jeli), Saç Bakım Ürünü (Doğal bitki özleri, saf bitkisel yağlar).',
                'benefits' => 'Zeytinyağı tabanlı formül. Saf bitki özleri ile zengin içerik. Cilde ve saça dost el yapımı bakım.',
                'usage' => 'Şampuanı ıslak saça köpürterek uygulayıp durulayın. Saç bakım yağını saç diplerine masaj yaparak uygulayıp durulayın.',
                'price' => 500.00,
                'image_path' => 'assets/ikili_bakim_seti.jpg',
                'in_stock' => true,
                'seo_title' => 'M. Çakır Can Özel İkili Bakım Seti | Sadece 500 TL',
                'seo_description' => 'Zeytinyağı tabanlı el yapımı lavanta şampuanı ve bitkisel saç bakım yağından oluşan Hatay Dörtyol üretimi avantajlı ikili bakım seti.',
                'og_title' => 'M. Çakır Can - Özel İkili Bakım Seti (Şampuan & Saç Yağı)',
                'og_description' => 'Sadece 500 TL fiyatıyla cilde ve saça dost saf bitki özlü ikili bakım seti.',
                'og_image' => null,
                'noindex' => false
            ],
            [
                'category_id' => $catOzel->id,
                'name' => 'M. Çakır Can - Saç Bakım Ürünü',
                'slug' => 'm-cakir-can-sac-bakim-urunu',
                'description' => 'Doğal bitki özleriyle saçlarınızı besleyen, parlaklık kazandıran ve kırılmaları önleyen saç bakım ürünü.',
                'ingredients' => 'Doğal bitki özleri, saf bitkisel yağlar.',
                'benefits' => 'Saç köklerini derinlemesine besler. Doğal parlaklık ve yumuşaklık kazandırır. Kırılmaları önlemeye yardımcı olur.',
                'usage' => 'Saç diplerine masaj yaparak uygulayın ve durulayın.',
                'price' => 200.00,
                'image_path' => 'assets/sac_bakim_yagi.jpg',
                'in_stock' => true,
                'seo_title' => 'M. Çakır Can Bitkisel Saç Bakım Yağı | Dökülme Karşıtı',
                'seo_description' => 'Doğal bitkisel yağlar ve vitaminlerle saç köklerini besleyen, kırılmaları önleyen ve hızlı uzama sağlayan saç bakım ürünü.',
                'og_title' => 'M. Çakır Can - Doğal & Bitkisel Saç Bakım Yağı',
                'og_description' => 'Saç köklerini besleyen, parlaklık kazandıran ve dökülmeyi önleyen saç bakım yağı.',
                'og_image' => null,
                'noindex' => false
            ],
            [
                'category_id' => $catDefne->id,
                'name' => 'Sabunmuş - El Yapımı Zeytin Yağı Sabunu (Defne & Aloe Vera)',
                'slug' => 'sabunmus-el-yapimi-zeytin-yagi-sabunu-defne-aloe-vera',
                'description' => 'El Yapımı Zeytin Yağı Sabunu. Defne & Aloe vera özleriyle zenginleştirilmiş, cildinizi besleyen ve nemlendiren geleneksel sabun.',
                'ingredients' => 'Saf zeytinyağı, defne yağı, aloe vera özü, kaynak suyu, sabun mayası.',
                'benefits' => 'Cildi derinlemesine nemlendirir. Defne yağı ile gözenekleri arındırır. Aloe vera ile cildi sakinleştirir.',
                'usage' => 'Islak cilde köpürterek uygulayın, durulayın.',
                'price' => 400.00,
                'image_path' => 'assets/defne_aloe_vera.jpg',
                'in_stock' => true,
                'seo_title' => 'Sabunmuş Defne & Aloe Veralı El Yapımı Zeytinyağı Sabunu',
                'seo_description' => 'Geleneksel soğuk sıkım zeytinyağı, defne yağı ve aloe vera jeli ile elde kesilen, nemlendirici ve gözenek arındırıcı el yapımı sabun.',
                'og_title' => 'Sabunmuş - Defne & Aloe Veralı Geleneksel Zeytinyağı Sabunu',
                'og_description' => 'Cildi kurutmadan temizleyen, defne yağıyla arındıran el yapımı kare sabun.',
                'og_image' => null,
                'noindex' => false
            ]
        ];

        // Clear old reviews first to avoid duplicates when running seeds
        \App\Models\Review::query()->delete();

        foreach ($products as $p) {
            $productObj = Product::create($p);
            
            // Add a couple of sample reviews for each product to show it off
            \App\Models\Review::create([
                'product_id' => $productObj->id,
                'name' => 'Ayşe Yılmaz',
                'rating' => 5,
                'comment' => 'Harika bir ürün, kesinlikle tavsiye ederim. Doğallığı kokusundan belli oluyor.'
            ]);
            \App\Models\Review::create([
                'product_id' => $productObj->id,
                'name' => 'Mehmet Demir',
                'rating' => 4,
                'comment' => 'Kargo hızlı geldi. Paketleme çok özenliydi. Cildimi yumuşacık yaptı.'
            ]);
        }
    }
}
