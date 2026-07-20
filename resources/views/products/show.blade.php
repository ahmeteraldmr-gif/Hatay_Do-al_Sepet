@extends('layouts.app')

@section('title', $product->seo_title ?: $product->name)

@section('meta_description', $product->seo_description ?: Str::limit(strip_tags($product->description), 150))

@if($product->noindex)
    @section('noindex', 'true')
@endif

@section('og_type', 'product')
@section('og_title', $product->og_title ?: $product->seo_title ?: $product->name)
@section('og_description', $product->og_description ?: $product->seo_description ?: Str::limit(strip_tags($product->description), 150))
@section('og_image', $product->og_image ? asset($product->og_image) : asset($product->image_path))

<script type="application/ld+json">
{
  "@@context": "https://schema.org/",
  "@@type": "Product",
  "name": "{{ $product->name }}",
  "image": [
    "{{ asset($product->image_path) }}"
  ],
  "description": "{{ strip_tags($product->description) }}",
  "sku": "product-{{ $product->id }}",
  "offers": {
    "@@type": "Offer",
    "url": "{{ url()->current() }}",
    "priceCurrency": "TRY",
    "price": "{{ $product->price }}",
    "availability": "{{ $product->in_stock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
    "priceValidUntil": "2027-12-31"
  }
}
</script>

@section('content')

    <style>
        .product-detail-card {
            background-color: var(--color-white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            padding: 40px;
            border: 1px solid rgba(74, 93, 78, 0.05);
        }

        .reviews-section-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 40px;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .product-detail-card {
                grid-template-columns: 1fr;
                padding: 20px;
                gap: 24px;
            }
            .reviews-section-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        }
    </style>

    <!-- --- PAGE BANNER --- -->
    <section class="page-banner banner-products" style="background-image: url('{{ asset('assets/banner_products.png') }}'); padding: 40px 0; min-height: auto;">
        <div class="container text-center">
            <h1>{{ $product->name }}</h1>
            <p>{{ $product->category->name }}</p>
        </div>
    </section>

    <!-- --- PRODUCT DETAIL SECTION --- -->
    <section class="product-detail-section section-padding" style="background-color: var(--color-bg); padding: 60px 0;">
        <div class="container" style="max-width: 1000px;">
            
            <div style="margin-bottom: 24px;">
                <a href="{{ route('products.index') }}" style="color: var(--color-primary); font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-arrow-left"></i> Kataloğa Geri Dön
                </a>
            </div>

            <div class="product-detail-card">
                
                <!-- Image column -->
                <div class="detail-image-wrapper" style="position: relative; border-radius: 8px; overflow: hidden; background-color: var(--color-bg); border: 1px solid rgba(74, 93, 78, 0.05); display: flex; align-items: center; justify-content: center; min-height: 350px;">
                    @if($product->image_path)
                        <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; max-height: 450px;">
                    @else
                        <div style="font-size: 80px; color: var(--color-primary-light); font-weight: bold;">
                            {{ mb_substr($product->name, 0, 1) }}
                        </div>
                    @endif
                    @if(!$product->in_stock)
                        <div style="position: absolute; top: 20px; left: 20px; background-color: #EF4444; color: white; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase;">Tükendi</div>
                    @endif
                </div>

                <!-- Info column -->
                <div class="detail-info-wrapper" style="display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <span style="color: var(--color-accent); font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 1px;">
                            {{ $product->category->name }}
                        </span>
                        <h2 style="font-family: var(--font-serif); font-size: 32px; color: var(--color-text); margin: 8px 0 16px 0; line-height: 1.2;">
                            {{ $product->name }}
                        </h2>
                        
                        <div style="font-size: 26px; font-weight: 700; color: var(--color-primary-dark); margin-bottom: 20px;">
                            {{ number_format($product->price, 2) }} TL
                        </div>

                        <p style="color: var(--color-text-light); line-height: 1.6; font-size: 15px; margin-bottom: 24px;">
                            {{ $product->description }}
                        </p>

                        <!-- Accordion Detail sections -->
                        <div class="detail-accordion" style="margin-bottom: 30px;">
                            @if($product->ingredients)
                                <div class="accordion-item" style="border-top: 1px solid rgba(74, 93, 78, 0.08); border-bottom: 1px solid rgba(74, 93, 78, 0.08);">
                                    <div class="accordion-title" onclick="toggleAccordion('ing-content', this)" style="padding: 12px 0; font-weight: 600; cursor: pointer; display: flex; justify-content: space-between; align-items: center; color: var(--color-text);">
                                        <span>İçindekiler</span>
                                        <i class="fa-solid fa-chevron-down" style="font-size: 12px; transition: transform 0.3s;"></i>
                                    </div>
                                    <div id="ing-content" class="accordion-desc" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; font-size: 14px; color: var(--color-text-light); line-height: 1.5;">
                                        <p style="padding-bottom: 12px;">{{ $product->ingredients }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($product->benefits)
                                <div class="accordion-item" style="border-bottom: 1px solid rgba(74, 93, 78, 0.08);">
                                    <div class="accordion-title" onclick="toggleAccordion('ben-content', this)" style="padding: 12px 0; font-weight: 600; cursor: pointer; display: flex; justify-content: space-between; align-items: center; color: var(--color-text);">
                                        <span>Faydaları</span>
                                        <i class="fa-solid fa-chevron-down" style="font-size: 12px; transition: transform 0.3s;"></i>
                                    </div>
                                    <div id="ben-content" class="accordion-desc" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; font-size: 14px; color: var(--color-text-light); line-height: 1.5;">
                                        <p style="padding-bottom: 12px;">{{ $product->benefits }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($product->usage)
                                <div class="accordion-item" style="border-bottom: 1px solid rgba(74, 93, 78, 0.08);">
                                    <div class="accordion-title" onclick="toggleAccordion('use-content', this)" style="padding: 12px 0; font-weight: 600; cursor: pointer; display: flex; justify-content: space-between; align-items: center; color: var(--color-text);">
                                        <span>Kullanım Şekli</span>
                                        <i class="fa-solid fa-chevron-down" style="font-size: 12px; transition: transform 0.3s;"></i>
                                    </div>
                                    <div id="use-content" class="accordion-desc" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; font-size: 14px; color: var(--color-text-light); line-height: 1.5;">
                                        <p style="padding-bottom: 12px;">{{ $product->usage }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div style="display: flex; gap: 16px;">
                        @if($product->in_stock)
                            <button class="btn btn-primary" onclick="addToCart('p-{{ $product->id }}', '{{ $product->name }}', '{{ $product->price }}', '{{ asset($product->image_path) }}')" style="flex-grow: 1; padding: 14px; font-weight: 600; border-radius: 8px; font-size: 15px; border: none; cursor: pointer;">
                                <i class="fa-solid fa-cart-shopping"></i> Sepete Ekle
                            </button>
                        @else
                            <button class="btn btn-secondary" style="flex-grow: 1; cursor: not-allowed; opacity: 0.6; padding: 14px; font-weight: 600; border-radius: 8px; font-size: 15px;" disabled>
                                Tükendi
                            </button>
                        @endif
                    </div>
                </div>

            </div>

            <!-- --- REVIEWS SECTION --- -->
            <div style="background-color: var(--color-white); border-radius: var(--border-radius); box-shadow: var(--shadow-md); padding: 40px; margin-top: 40px; border: 1px solid rgba(74, 93, 78, 0.05);">
                <h3 style="font-family: var(--font-serif); font-size: 24px; color: var(--color-text); margin: 0 0 10px 0; border-bottom: 2px solid rgba(74, 93, 78, 0.05); padding-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-regular fa-comments" style="color: var(--color-primary);"></i> Müşteri Değerlendirmeleri
                </h3>
                
                @if(session('success'))
                    <div style="background-color: rgba(74, 93, 78, 0.08); color: var(--color-primary-dark); padding: 12px 16px; border-radius: 8px; font-weight: 600; font-size: 14px; margin-bottom: 20px; border: 1px solid rgba(74, 93, 78, 0.15);">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                    </div>
                @endif

                <div class="reviews-section-grid">
                    <!-- Left: Reviews List -->
                    <div>
                        @php
                            $avgRating = $product->reviews->avg('rating') ?: 0;
                            $totalReviews = $product->reviews->count();
                        @endphp
                        
                        <div style="display: flex; align-items: center; gap: 15px; background-color: var(--color-bg); padding: 20px; border-radius: 12px; border: 1px solid rgba(74, 93, 78, 0.03); margin-bottom: 25px;">
                            <div style="font-size: 40px; font-weight: 800; color: var(--color-primary-dark); line-height: 1;">
                                {{ number_format($avgRating, 1) }}
                            </div>
                            <div>
                                <div style="display: flex; gap: 2px; color: #FBBF24; font-size: 18px; margin-bottom: 4px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($avgRating))
                                            <i class="fa-solid fa-star"></i>
                                        @else
                                            <i class="fa-regular fa-star" style="color: #D1D5DB;"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span style="font-size: 13.5px; color: var(--color-text-light); font-weight: 600;">
                                    {{ $totalReviews }} Müşteri Değerlendirmesi
                                </span>
                            </div>
                        </div>

                        <div style="max-height: 500px; overflow-y: auto; padding-right: 10px;">
                            @forelse($product->reviews as $review)
                                <div style="border-bottom: 1px solid rgba(74, 93, 78, 0.08); padding: 18px 0; {{ $loop->last ? 'border-bottom: none; padding-bottom: 0;' : '' }}">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; flex-wrap: wrap; gap: 8px;">
                                        <strong style="color: var(--color-text); font-size: 15px;">{{ $review->name }}</strong>
                                        <span style="font-size: 12px; color: var(--color-text-light);"><i class="fa-regular fa-clock"></i> {{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    
                                    <div style="display: flex; gap: 2px; color: #FBBF24; font-size: 13px; margin-bottom: 10px;">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fa-solid fa-star"></i>
                                            @else
                                                <i class="fa-regular fa-star" style="color: #D1D5DB;"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    
                                    <p style="font-size: 14px; color: var(--color-text-light); line-height: 1.6; margin: 0; white-space: pre-line;">{{ $review->comment }}</p>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 40px 10px; color: var(--color-text-light);">
                                    <i class="fa-regular fa-comment-dots" style="font-size: 40px; margin-bottom: 12px; display: block; opacity: 0.4;"></i>
                                    Bu ürün için henüz değerlendirme yapılmamış. İlk yorumu siz yapın!
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Right: Add Review Form -->
                    <div style="background-color: var(--color-bg); padding: 25px; border-radius: 12px; border: 1px solid rgba(74, 93, 78, 0.05); align-self: flex-start;">
                        <h4 style="font-family: var(--font-serif); font-size: 18px; color: var(--color-text); margin: 0 0 15px 0;">Yorum Yazın</h4>
                        
                        <form action="{{ route('products.review.store', $product->id) }}" method="POST">
                            @csrf
                            
                            <div style="margin-bottom: 15px;">
                                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--color-text); margin-bottom: 6px;">Puanınız *</label>
                                <div class="star-rating" style="display: flex; gap: 8px; font-size: 26px; cursor: pointer; color: #D1D5DB;">
                                    <i class="fa-solid fa-star star-btn" data-value="1"></i>
                                    <i class="fa-solid fa-star star-btn" data-value="2"></i>
                                    <i class="fa-solid fa-star star-btn" data-value="3"></i>
                                    <i class="fa-solid fa-star star-btn" data-value="4"></i>
                                    <i class="fa-solid fa-star star-btn" data-value="5"></i>
                                </div>
                                <input type="hidden" name="rating" id="rating-input" value="5" required>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label for="review-name" style="display: block; font-size: 13.5px; font-weight: 600; color: var(--color-text); margin-bottom: 6px;">Adınız Soyadınız *</label>
                                <input type="text" name="name" id="review-name" style="width: 100%; padding: 10px 14px; border: 1px solid rgba(74, 93, 78, 0.15); border-radius: 6px; font-size: 14.5px; outline: none; background-color: var(--color-white);" placeholder="Örn: Ayşe Yılmaz" required>
                            </div>

                            <div style="margin-bottom: 20px;">
                                <label for="review-comment" style="display: block; font-size: 13.5px; font-weight: 600; color: var(--color-text); margin-bottom: 6px;">Yorumunuz *</label>
                                <textarea name="comment" id="review-comment" rows="4" style="width: 100%; padding: 10px 14px; border: 1px solid rgba(74, 93, 78, 0.15); border-radius: 6px; font-size: 14.5px; outline: none; background-color: var(--color-white); resize: vertical;" placeholder="Sabun hakkındaki görüşleriniz..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-weight: 600; border-radius: 6px; font-size: 14.5px; border: none; cursor: pointer;">
                                Değerlendirmeyi Gönder
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection

@section('scripts')
    <script>
        function toggleAccordion(id, header) {
            const content = document.getElementById(id);
            const icon = header.querySelector('i');
            
            if (content.style.maxHeight && content.style.maxHeight !== '0px') {
                content.style.maxHeight = '0px';
                icon.style.transform = 'rotate(0deg)';
            } else {
                // Close all
                document.querySelectorAll('.accordion-desc').forEach(desc => {
                    desc.style.maxHeight = '0px';
                });
                document.querySelectorAll('.accordion-title i').forEach(itemIcon => {
                    itemIcon.style.transform = 'rotate(0deg)';
                });
                
                // Open this
                content.style.maxHeight = content.scrollHeight + "px";
                icon.style.transform = 'rotate(180deg)';
            }
        }
        
        // Auto open first accordion on load
        window.addEventListener('DOMContentLoaded', () => {
            const firstHeader = document.querySelector('.accordion-title');
            if (firstHeader) {
                firstHeader.click();
            }
        });

        // Star rating picker logic
        document.addEventListener('DOMContentLoaded', () => {
            const stars = document.querySelectorAll('.star-btn');
            const ratingInput = document.getElementById('rating-input');
            
            if (stars.length > 0) {
                // Set initial state (5 stars)
                updateStars(5);
                
                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const rating = parseInt(this.getAttribute('data-value'));
                        ratingInput.value = rating;
                        updateStars(rating);
                    });
                    
                    // Hover effect preview
                    star.addEventListener('mouseover', function() {
                        const rating = parseInt(this.getAttribute('data-value'));
                        previewStars(rating);
                    });
                });
                
                const starContainer = document.querySelector('.star-rating');
                if (starContainer) {
                    starContainer.addEventListener('mouseleave', () => {
                        const currentRating = parseInt(ratingInput.value);
                        updateStars(currentRating);
                    });
                }
            }
            
            function updateStars(rating) {
                stars.forEach(star => {
                    const val = parseInt(star.getAttribute('data-value'));
                    if (val <= rating) {
                        star.style.color = '#FBBF24';
                    } else {
                        star.style.color = '#D1D5DB';
                    }
                });
            }
            
            function previewStars(rating) {
                stars.forEach(star => {
                    const val = parseInt(star.getAttribute('data-value'));
                    if (val <= rating) {
                        star.style.color = '#F59E0B'; // Slightly darker yellow on hover
                    } else {
                        star.style.color = '#D1D5DB';
                    }
                });
            }
        });
    </script>
@endsection
