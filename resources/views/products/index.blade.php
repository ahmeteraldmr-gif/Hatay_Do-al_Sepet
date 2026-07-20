@extends('layouts.app')

@php
    $pageTitle = 'Ürünlerimiz';
    $metaDesc = 'Hatay\'ın geleneksel el yapımı defne sabunları, zeytinyağı sabunları, doğal şampuan ve cilt bakım setleri.';
    $noIndex = false;
    $ogTitle = null;
    $ogDesc = null;
    $ogImg = null;

    if (isset($category)) {
        $pageTitle = $category->seo_title ?: $category->name . ' Ürünleri';
        $metaDesc = $category->seo_description ?: $category->description;
        $noIndex = $category->noindex;
        $ogTitle = $category->og_title ?: $category->seo_title ?: $category->name;
        $ogDesc = $category->og_description ?: $category->seo_description ?: $category->description;
        $ogImg = $category->og_image ? asset($category->og_image) : null;
    }
@endphp

@section('title', $pageTitle)
@section('meta_description', $metaDesc)
@section('noindex', $noIndex ? 'true' : '')
@section('og_title', $ogTitle)
@section('og_description', $ogDesc)
@section('og_image', $ogImg)

@section('content')

    <!-- --- PAGE BANNER --- -->
    <section class="page-banner banner-products" style="background-image: url('{{ asset('assets/banner_products.png') }}');">
        <div class="container text-center">
            <h1>Doğal Sabun Koleksiyonumuz</h1>
            <p>Kimyasallardan uzak, doğanın ve cildinizin dostu geleneksel el yapımı sabunlar</p>
        </div>
    </section>

    <!-- --- PRODUCTS SECTION --- -->
    <section class="products-section section-padding">
        <div class="container">
            
            <!-- Kategori Filtreleri -->
            <div class="filter-container">
                <button class="filter-btn {{ !request()->has('category') ? 'active' : '' }}" data-filter="all">🌿 Tüm Sabunlar</button>
                @foreach(\App\Models\Category::all() as $cat)
                    <button class="filter-btn {{ request()->category == $cat->slug ? 'active' : '' }}" data-filter="{{ $cat->slug }}">{{ $cat->emoji }} {{ $cat->name }}</button>
                @endforeach
            </div>

            <!-- Ürün Izgarası -->
            <div class="products-grid">
                @foreach(\App\Models\Product::with('category')->orderBy('name', 'asc')->get() as $product)
                    <div class="product-card product-card-item" data-category="{{ $product->category->slug }}">
                        @if(!$product->in_stock)
                            <div class="product-badge" style="background-color: #EF4444;">Tükendi</div>
                        @elseif($product->price > 100)
                            <div class="product-badge">Lüks</div>
                        @else
                            <div class="product-badge">Doğal</div>
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
                            <p class="product-desc">{{ $product->description }}</p>
                            
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
                                    <span>🌿 Doğal İçerik</span>
                                    <span>🌿 Katkısız</span>
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
        </div>
    </section>

@endsection

@section('scripts')
    @if(request()->has('category'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                const activeFilter = "{{ request()->category }}";
                const productItems = document.querySelectorAll('.product-card-item');
                
                productItems.forEach(item => {
                    const category = item.getAttribute('data-category');
                    if (category === activeFilter) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        </script>
    @endif
@endsection
