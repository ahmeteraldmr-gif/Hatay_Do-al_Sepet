@extends('layouts.app')

@section('title', $product->name)

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

        @media (max-width: 768px) {
            .product-detail-card {
                grid-template-columns: 1fr;
                padding: 20px;
                gap: 24px;
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
    </script>
@endsection
