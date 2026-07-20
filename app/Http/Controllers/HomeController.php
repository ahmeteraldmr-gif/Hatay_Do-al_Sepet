<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        \App\Models\Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        // Store contact success message in session
        return back()->with('contact_success', 'Mesajınız başarıyla iletildi! En kısa sürede sizinle iletişime geçeceğiz.');
    }

    public function sitemap()
    {
        $categories = \App\Models\Category::where('noindex', false)->get();
        $products = \App\Models\Product::where('noindex', false)->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // 1. Static Pages
        $staticUrls = [
            ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => route('about'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => route('contact'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('products.index'), 'priority' => '0.9', 'changefreq' => 'daily'],
        ];

        foreach ($staticUrls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($url['loc']) . '</loc>';
            $xml .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
            $xml .= '<changefreq>' . $url['changefreq'] . '</changefreq>';
            $xml .= '<priority>' . $url['priority'] . '</priority>';
            $xml .= '</url>';
        }

        // 2. Categories
        foreach ($categories as $category) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars(route('products.index', ['category' => $category->slug])) . '</loc>';
            $xml .= '<lastmod>' . $category->updated_at->toAtomString() . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.8</priority>';
            $xml .= '</url>';
        }

        // 3. Products
        foreach ($products as $product) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars(route('products.show', $product->slug)) . '</loc>';
            $xml .= '<lastmod>' . $product->updated_at->toAtomString() . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.7</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
