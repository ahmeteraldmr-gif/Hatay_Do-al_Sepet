<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'whatsapp_number' => '905551234567',
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
            ['name' => 'Defne Sabunları', 'emoji' => '🍃', 'description' => 'Yabani defne ağacı yağı ile zeytinyağının birleşimi. Saç ve cilt şifası.']
        );

        $catZeytin = Category::updateOrCreate(
            ['slug' => 'zeytinyagi-sabunlari'],
            ['name' => 'Zeytinyağı Sabunları', 'emoji' => '🫒', 'description' => '%100 saf Hatay zeytinyağından üretilen, cildi kurutmayan besleyici sabunlar.']
        );

        $catOzel = Category::updateOrCreate(
            ['slug' => 'bitkisel-ve-kokulu-sabunlar'],
            ['name' => 'Aromaterapi Serisi', 'emoji' => '🌸', 'description' => 'Bitkisel özler ve doğal uçucu yağlarla zenginleştirilmiş özel kokulu sabunlar.']
        );

        // 4. Seed Products
        $products = [
            [
                'category_id' => $catDefne->id,
                'name' => 'Geleneksel %80 Defne Yağlı Gar Sabunu',
                'slug' => 'geleneksel-80-defne-yagli-gar-sabunu',
                'description' => 'Antiseptik özelliği ile saç ve saç derisini besler, kepeklenmeyi önlemeye yardımcı olur.',
                'ingredients' => 'Saf defne yağı (%80), sızma zeytinyağı, kaynak suyu, sabun mayası.',
                'benefits' => 'Saç ve saç derisi sağlığı. Kepek önleyici bariyer. Derin gözenek temizliği.',
                'usage' => 'Islak saça masaj yaparak uygulayın, 1-2 dakika bekletip bol su ile durulayın.',
                'price' => 95.00,
                'image_path' => 'assets/laurel.png',
                'in_stock' => true
            ],
            [
                'category_id' => $catZeytin->id,
                'name' => 'Saf Sızma Zeytinyağlı Bebek Sabunu',
                'slug' => 'saf-sizma-zeytinyagli-bebek-sabunu',
                'description' => 'En hassas ciltler için bile uygundur, E vitamini ile cildi derinlemesine nemlendirir.',
                'ingredients' => 'Saf sızma zeytinyağı, kaynak suyu, sabun mayası.',
                'benefits' => 'Hassas ciltlerle uyumlu. Yoğun E vitamini desteği. Doğal ve yumuşak nem.',
                'usage' => 'El, yüz ve vücut temizliğinde köpürterek uygulayın ve durulayın.',
                'price' => 75.00,
                'image_path' => 'assets/olive_oil.png',
                'in_stock' => true
            ],
            [
                'category_id' => $catOzel->id,
                'name' => 'Rahatlatıcı Doğal Lavanta Sabunu',
                'slug' => 'rahatlatici-dogal-lavanta-sabunu',
                'description' => 'Doğal lavanta yağı ve kurutulmuş lavanta tanecikleri ile dinlendirici bir banyo deneyimi sunar.',
                'ingredients' => 'Bitkisel yağlar, lavanta uçucu yağı, kurutulmuş lavanta çiçekleri.',
                'benefits' => 'Stres giderici aroma. Doğal peeling tanecikleri. Cildi dinlendiren etki.',
                'usage' => ' Banyoda tüm vücudunuza masaj yaparak uygulayın.',
                'price' => 85.00,
                'image_path' => 'assets/lavender.png',
                'in_stock' => true
            ],
            [
                'category_id' => $catDefne->id,
                'name' => 'Hatay Bıttım (Yabani Fıstık Yağı) Sabunu',
                'slug' => 'hatay-bittim-sabunu',
                'description' => 'Yabani bıttım meyvesinin yağından üretilmiştir. Saç dökülmesini durdurmada son derece etkilidir.',
                'ingredients' => 'Yabani bıttım (menengiç) yağı, zeytinyağı, kaynak suyu, sabun mayası.',
                'benefits' => 'Saç dökülmesi karşıtı. Saç kökü güçlendirme. Kepeğe karşı etkin koruma.',
                'usage' => 'Islak saça köpürterek uygulayın ve saç derisine masaj yapın.',
                'price' => 90.00,
                'image_path' => 'assets/pistachio.png',
                'in_stock' => true
            ],
            [
                'category_id' => $catOzel->id,
                'name' => 'Lüks Nemlendirici Eşek Sütü Sabunu',
                'slug' => 'luks-nemlendirici-esek-sutu-sabunu',
                'description' => 'Zengin vitamin ve minerallerle cilt kırışıklıklarına ve lekelere karşı yaşlanma karşıtı bakım yapar.',
                'ingredients' => 'Doğal eşek sütü, zeytinyağı, hindistan cevizi yağı, sabun mayası.',
                'benefits' => 'Yaşlanma karşıtı (Anti-Aging). Cilt lekesi giderici etki. A, B, C, D, E vitamin deposu.',
                'usage' => 'Yüzünüzü yıkadıktan sonra köpüğüyle maske gibi 1 dakika bekletip yıkayın.',
                'price' => 110.00,
                'image_path' => 'assets/donkey_milk.png',
                'in_stock' => true
            ],
            [
                'category_id' => $catZeytin->id,
                'name' => 'Arındırıcı Doğal Kükürt Sabunu',
                'slug' => 'arindirici-dogal-kukurt-sabunu',
                'description' => 'Ciltteki aşırı yağlanmayı dengeler, sivilce ve akne oluşumunu önlemeye yardımcı olur.',
                'ingredients' => 'Doğal kükürt tozu, zeytinyağı, su, sabun mayası.',
                'benefits' => 'Sivilce ve akne karşıtı. Sebum (Yağ) dengesi. Derin gözenek arındırma.',
                'usage' => 'Özellikle yağlı cilt bölgelerine dairesel hareketlerle uygulayın.',
                'price' => 80.00,
                'image_path' => 'assets/sulfur.png',
                'in_stock' => true
            ],
            [
                'category_id' => $catDefne->id,
                'name' => 'Geleneksel Ardıç Katranı Sabunu',
                'slug' => 'geleneksel-ardic-katrani-sabunu',
                'description' => 'Sedef, egzama ve kaşıntılı cilt sorunlarında yatıştırıcı etkisiyle bilinen asırlık formül.',
                'ingredients' => 'Doğal ardıç katranı yağı, sızma zeytinyağı, kaynak suyu.',
                'benefits' => 'Egzama ve sedef yatıştırıcı. Kaşıntı önleyici formül. Antiseptik doğal bariyer.',
                'usage' => 'Sorunlu cilt bölgesini köpürterek yıkayın, bol su ile durulayın.',
                'price' => 95.00,
                'image_path' => 'assets/juniper.png',
                'in_stock' => true
            ],
            [
                'category_id' => $catOzel->id,
                'name' => 'Gençleştirici Doğal Gül Sabunu',
                'slug' => 'genclestirici-dogal-gul-sabunu',
                'description' => 'Gerçek gül yağı ve yapraklarıyla cildi sıkılaştırır, doğal tonik etkisiyle gözenekleri arındırır.',
                'ingredients' => 'Gül uçucu yağı, kurutulmuş gül yaprakları, bitkisel yağlar.',
                'benefits' => 'Cilt sıkılaştırıcı etki. Gözenek küçültücü tonik. Canlandırıcı gül aroması.',
                'usage' => 'Yüzünüzü ılık suyla köpürterek yıkayın ve nazikçe kurulayın.',
                'price' => 100.00,
                'image_path' => 'assets/rose.png',
                'in_stock' => true
            ],
            [
                'category_id' => $catOzel->id,
                'name' => 'Besleyici Doğal Keçi Sütü Sabunu',
                'slug' => 'besleyici-dogal-keci-sutu-sabunu',
                'description' => 'Doğal peeling etkisiyle ölü deriyi temizler ve zengin mineral yapısıyla cildi pürüzsüzleştirir.',
                'ingredients' => 'Doğal taze keçi sütü, sızma zeytinyağı, hindistan cevizi yağı.',
                'benefits' => 'Doğal peeling etkisi. Pürüzsüzleştirici formül. Laktik asit ile derin nem.',
                'usage' => 'Yüz ve vücut temizliğinde her gün kullanıma uygundur.',
                'price' => 90.00,
                'image_path' => 'assets/goat_milk.png',
                'in_stock' => true
            ],
            [
                'category_id' => $catOzel->id,
                'name' => 'Aktif Karbon Detoks Sabunu',
                'slug' => 'aktif-karbon-detoks-sabunu',
                'description' => 'Mıknatıs etkisiyle gözeneklerdeki kiri ve siyah noktaları çeker, cilde detoks etkisi yapar.',
                'ingredients' => 'Aktif karbon (kömür) tozu, zeytinyağı, çay ağacı yağı, su.',
                'benefits' => 'Siyah nokta ve kir mıknatısı. Gözenek sıkılaştırıcı etki. Sebum kontrolü & matlık.',
                'usage' => 'Siyah nokta eğilimli T-bölgesine köpürterek masaj yapın.',
                'price' => 95.00,
                'image_path' => 'assets/charcoal.png',
                'in_stock' => true
            ],
            [
                'category_id' => $catOzel->id,
                'name' => 'Sakinleştirici Papatya Sabunu',
                'slug' => 'sakinlestirici-papatya-sabunu',
                'description' => 'Tahriş olmuş ciltleri sakinleştirir, göz çevresi temizliği ve makyaj kalıntısı arındırmada idealdir.',
                'ingredients' => 'Papatya uçucu yağı, papatya çiçekleri, zeytinyağı, kaynak suyu.',
                'benefits' => 'Tahriş yatıştırıcı etki. Hassas makyaj temizliği. Sakinleştirici bitki özleri.',
                'usage' => 'Makyaj temizliğinde yüzünüzü yıkayıp ılık suyla durulayın.',
                'price' => 85.00,
                'image_path' => 'assets/goat_milk.png', // fallback
                'in_stock' => true
            ],
            [
                'category_id' => $catOzel->id,
                'name' => 'Ferahlatıcı Nane & Okaliptüs Sabunu',
                'slug' => 'ferahlatici-nane-okaliptus-sabunu',
                'description' => 'Yoğun mentol etkisiyle cilde ferahlık verir, sabah banyolarında vücuda zindelik kazandırır.',
                'ingredients' => 'Nane uçucu yağı, okaliptüs yağı, nane yaprakları, bitkisel gliserin.',
                'benefits' => 'Canlandırıcı mentol ferahlığı. Kan dolaşımı hızlandırıcı. Tıkanıklık açıcı nefes aroması.',
                'usage' => 'Özellikle sabah duşlarında tüm vücuda uygulayarak zindelik kazanın.',
                'price' => 80.00,
                'image_path' => 'assets/laurel.png', // fallback
                'in_stock' => true
            ],
            [
                'category_id' => $catZeytin->id,
                'name' => 'Bal & Yulaf Ezmeli Hassas Sabun',
                'slug' => 'bal-yulaf-ezmeli-hassas-sabun',
                'description' => 'Yulaf tanecikleriyle cildi tahriş etmeden temizler, çam balı özleriyle kuru ciltleri derinlemesine besler.',
                'ingredients' => 'Doğal süzme bal, yulaf ezmesi tanecikleri, zeytinyağı, su.',
                'benefits' => 'Kuru ciltlere yoğun nem. Tahriş etmeyen peeling. Doğal koruyucu bal filmi.',
                'usage' => 'Islak cilde yulaf taneciklerinin masaj etkisini hissettirecek şekilde uygulayın.',
                'price' => 90.00,
                'image_path' => 'assets/olive_oil.png', // fallback
                'in_stock' => true
            ],
            [
                'category_id' => $catDefne->id,
                'name' => 'Güçlendirici Doğal Kekik Sabunu',
                'slug' => 'guclendirici-dogal-kekik-sabunu',
                'description' => 'Güçlü bileşenleriyle mantar oluşumuna karşı korur, ayak kokusu ve terleme problemlerini azaltır.',
                'ingredients' => 'Doğal kekik yağı, zeytinyağı, kaynak suyu, sabun mayası.',
                'benefits' => 'Mantar ve koku önleyici. Derinlemesine vücut hijyeni. Doğal ter dengeleme.',
                'usage' => 'Banyo ve özellikle ayak temizliğinde köpürterek kullanın.',
                'price' => 85.00,
                'image_path' => 'assets/juniper.png', // fallback
                'in_stock' => true
            ],
            [
                'category_id' => $catOzel->id,
                'name' => 'Canlandırıcı Biberiye Sabunu',
                'slug' => 'canlandirici-biberiye-sabunu',
                'description' => 'Kan dolaşımını hızlandırarak selülit görünümünü azaltmaya yardımcı olur, cildi canlandırıp sıkılaştırır.',
                'ingredients' => 'Biberiye uçucu yağı, biberiye yaprakları, sızma zeytinyağı.',
                'benefits' => 'Selülit karşıtı masaj etkisi. Cilt elastikiyeti artırıcı. Odaklanma artırıcı aroma.',
                'usage' => 'Duşta lif yardımıyla sorunlu bölgelere yukarı doğru masaj yaparak uygulayın.',
                'price' => 90.00,
                'image_path' => 'assets/pistachio.png', // fallback
                'in_stock' => true
            ]
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
