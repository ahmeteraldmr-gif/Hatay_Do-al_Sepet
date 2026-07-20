<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        $category = null;
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }
        
        $products = $query->orderBy('name', 'asc')
                          ->paginate(9);
                          
        return view('products.index', compact('products', 'category'));
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'reviews' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->where('slug', $slug)->firstOrFail();
        return view('products.show', compact('product'));
    }

    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        \App\Models\Review::create([
            'product_id' => $id,
            'name' => $request->name,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Yorumunuz başarıyla gönderildi ve yayınlandı.');
    }
}
