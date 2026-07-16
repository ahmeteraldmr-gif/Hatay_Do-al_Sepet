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
                'in_stock' => true
            ],
            [
                'category_id' => $catOzel->id,
                'name' => 'M. Çakır Can - El Yapımı Lavanta & Aloe Vera Şampuanı',
                'slug' => 'm-cakir-can-el-yapimi-lavanta-aloe-vera-sampuani',
                'description' => 'Zeytinyağı tabanlı, saf bitki özleri içeren cilde dost el yapımı lavanta ve aloe vera şampuanı.',
                'ingredients' => 'Saf zeytinyağı, lavanta özü, aloe vera jeli, doğal şampuan bazı.',
                'benefits' => 'Zeytinyağı tabanlı formül. Saf lavanta ve aloe vera özleri. Cilde ve saç derisine dost temizlik.',
                'usage' => 'Islak saça köpürterek uygulayın, durulayın.',
                'price' => 300.00,
                'image_path' => 'assets/lavanta_sampuan.jpg',
                'in_stock' => true
            ],
            [
                'category_id' => $catOzel->id,
                'name' => 'M. Çakır Can - El Yapımı Yeşil Elma & Aloe Vera Şampuanı',
                'slug' => 'm-cakir-can-el-yapimi-yesil-elma-aloe-vera-sampuani',
                'description' => 'Yeşil elma ve aloe vera özleriyle zenginleştirilmiş, zeytinyağı tabanlı doğal el yapımı şampuan.',
                'ingredients' => 'Saf zeytinyağı, yeşil elma özü, aloe vera jeli, bitkisel temizleyiciler.',
                'benefits' => 'Doğal elma aromasıyla ferahlık. Zeytinyağı ile saçları besler. %100 el yapımı ve cilde dost.',
                'usage' => 'Islak saça köpürterek uygulayın, durulayın.',
                'price' => 300.00,
                'image_path' => 'assets/elma_sampuan.jpg',
                'in_stock' => true
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
                'in_stock' => true
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
                'in_stock' => true
            ]
        ];

        foreach ($products as $p) {
            Product::create($p);
        }
    }
}
