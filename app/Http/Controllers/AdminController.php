<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // Show login page
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    // Process login request
    public function loginSubmit(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Girdiğiniz bilgiler yöneticilik yetkileriyle uyuşmuyor.',
        ])->onlyInput('email');
    }

    // Process logout request
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    // Admin Dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Products list, add, edit
    public function products(Request $request)
    {
        $editProduct = null;
        if ($request->has('edit')) {
            $editProduct = Product::findOrFail($request->edit);
        }

        $products = Product::with('category')
                           ->orderBy('created_at', 'desc')
                           ->paginate(10);

        return view('admin.products', compact('products', 'editProduct'));
    }

    // Store new product
    public function productStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'ingredients' => 'nullable|string',
            'benefits' => 'nullable|string',
            'usage' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
        }

        $ogImagePath = null;
        if ($request->hasFile('og_image')) {
            $ogImage = $request->file('og_image');
            $ogImageName = 'og_' . time() . '_' . Str::slug($request->name) . '.' . $ogImage->getClientOriginalExtension();
            $ogImage->move(public_path('images'), $ogImageName);
            $ogImagePath = 'images/' . $ogImageName;
        }

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . rand(100, 999),
            'price' => $request->price,
            'description' => $request->description,
            'ingredients' => $request->ingredients,
            'benefits' => $request->benefits,
            'usage' => $request->usage,
            'image_path' => $imagePath,
            'in_stock' => $request->has('in_stock') ? true : false,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
            'og_image' => $ogImagePath,
            'noindex' => $request->has('noindex') ? true : false,
        ]);

        return redirect()->route('admin.products')->with('success', 'Doğal sabun başarıyla kataloğa eklendi.');
    }

    // Update existing product
    public function productUpdate(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'ingredients' => 'nullable|string',
            'benefits' => 'nullable|string',
            'usage' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $imagePath = $product->image_path;
        if ($request->hasFile('image')) {
            // Delete old custom image if exists (but don't delete standard seeded images)
            if ($product->image_path && 
                File::exists(public_path($product->image_path)) && 
                !in_array($product->image_path, ['images/laurel_soap.png', 'images/olive_oil_soap.png', 'images/lavender_soap.png'])) {
                File::delete(public_path($product->image_path));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
        }

        $ogImagePath = $product->og_image;
        if ($request->hasFile('og_image')) {
            if ($product->og_image && File::exists(public_path($product->og_image))) {
                File::delete(public_path($product->og_image));
            }

            $ogImage = $request->file('og_image');
            $ogImageName = 'og_' . time() . '_' . Str::slug($request->name) . '.' . $ogImage->getClientOriginalExtension();
            $ogImage->move(public_path('images'), $ogImageName);
            $ogImagePath = 'images/' . $ogImageName;
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . $product->id, // keep it unique but consistent
            'price' => $request->price,
            'description' => $request->description,
            'ingredients' => $request->ingredients,
            'benefits' => $request->benefits,
            'usage' => $request->usage,
            'image_path' => $imagePath,
            'in_stock' => $request->has('in_stock') ? true : false,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
            'og_image' => $ogImagePath,
            'noindex' => $request->has('noindex') ? true : false,
        ]);

        return redirect()->route('admin.products')->with('success', 'Ürün detayları başarıyla güncellendi.');
    }

    // Toggle stock status
    public function productToggleStock($id)
    {
        $product = Product::findOrFail($id);
        $product->in_stock = !$product->in_stock;
        $product->save();

        return redirect()->route('admin.products')->with('success', 'Ürün stok durumu başarıyla güncellendi.');
    }

    // Delete product
    public function productDelete($id)
    {
        $product = Product::findOrFail($id);

        // Delete image file if exists (and is not standard seeded image)
        if ($product->image_path && 
            File::exists(public_path($product->image_path)) && 
            !in_array($product->image_path, ['images/laurel_soap.png', 'images/olive_oil_soap.png', 'images/lavender_soap.png'])) {
            File::delete(public_path($product->image_path));
        }

        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Ürün başarıyla silindi.');
    }

    // Show settings page
    public function settings()
    {
        return view('admin.settings');
    }

    // Update settings
    public function settingsUpdate(Request $request)
    {
        $settings = $request->validate([
            'site_title' => 'required|string|max:255',
            'site_tagline' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'contact_address' => 'nullable|string|max:500',
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string',
            'about_text' => 'required|string',
        ]);

        // Strip spaces or non-digits from WhatsApp number for clean links
        $settings['whatsapp_number'] = preg_replace('/[^0-9]/', '', $settings['whatsapp_number']);

        foreach ($settings as $key => $value) {
            Setting::setValue($key, $value);
        }

        return redirect()->route('admin.settings')->with('success', 'Site ayarları başarıyla güncellendi.');
    }

    // Categories list page
    public function categories(Request $request)
    {
        $editCategory = null;
        if ($request->has('edit')) {
            $editCategory = Category::findOrFail($request->edit);
        }

        $categories = Category::withCount('products')->get();
        return view('admin.categories', compact('categories', 'editCategory'));
    }

    // Store new category
    public function categoryStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'emoji' => 'required|string|max:10',
            'description' => 'nullable|string|max:500',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $ogImagePath = null;
        if ($request->hasFile('og_image')) {
            $ogImage = $request->file('og_image');
            $ogImageName = 'og_cat_' . time() . '_' . Str::slug($request->name) . '.' . $ogImage->getClientOriginalExtension();
            $ogImage->move(public_path('images'), $ogImageName);
            $ogImagePath = 'images/' . $ogImageName;
        }

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'emoji' => $request->emoji,
            'description' => $request->description,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
            'og_image' => $ogImagePath,
            'noindex' => $request->has('noindex') ? true : false,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Kategori başarıyla oluşturuldu.');
    }

    // Update existing category
    public function categoryUpdate(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'emoji' => 'required|string|max:10',
            'description' => 'nullable|string|max:500',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $ogImagePath = $category->og_image;
        if ($request->hasFile('og_image')) {
            if ($category->og_image && File::exists(public_path($category->og_image))) {
                File::delete(public_path($category->og_image));
            }

            $ogImage = $request->file('og_image');
            $ogImageName = 'og_cat_' . time() . '_' . Str::slug($request->name) . '.' . $ogImage->getClientOriginalExtension();
            $ogImage->move(public_path('images'), $ogImageName);
            $ogImagePath = 'images/' . $ogImageName;
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'emoji' => $request->emoji,
            'description' => $request->description,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
            'og_image' => $ogImagePath,
            'noindex' => $request->has('noindex') ? true : false,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Kategori detayları başarıyla güncellendi.');
    }

    // Delete category
    public function categoryDelete($id)
    {
        $category = Category::findOrFail($id);
        
        // Delete og_image file if exists
        if ($category->og_image && File::exists(public_path($category->og_image))) {
            File::delete(public_path($category->og_image));
        }

        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Kategori ve bu kategoriye ait tüm ürünler silindi.');
    }

    // Messages list page
    public function messages(Request $request)
    {
        $messages = \App\Models\Message::orderBy('created_at', 'desc')->get();
        return view('admin.messages', compact('messages'));
    }

    // Toggle message read status
    public function messageRead($id)
    {
        $message = \App\Models\Message::findOrFail($id);
        $message->is_read = !$message->is_read;
        $message->save();

        return redirect()->route('admin.messages')->with('success', 'Mesaj okundu/okunmadı olarak işaretlendi.');
    }

    // Delete message
    public function messageDelete($id)
    {
        $message = \App\Models\Message::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.messages')->with('success', 'Mesaj başarıyla silindi.');
    }
}
