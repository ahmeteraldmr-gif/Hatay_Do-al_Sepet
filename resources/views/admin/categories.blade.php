@extends('layouts.admin')

@section('title', 'Kategori Yönetimi')

@section('content')

    <!-- Case 1: Edit Category -->
    @if(isset($editCategory))
        <div class="form-card" style="margin-bottom: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="margin-bottom: 0; font-size: 16px; font-weight: 600;"><i class="fa-solid fa-pen-to-square"></i> Kategoriyi Düzenle: {{ $editCategory->name }}</h3>
                <a href="{{ route('admin.categories') }}" style="font-size: 14px; text-decoration: underline; color: var(--text-muted);">
                    <i class="fa-solid fa-arrow-left"></i> Yeni Ekleme Moduna Dön
                </a>
            </div>
            
            <form action="{{ route('admin.categories.update', $editCategory->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label for="name" class="form-label">Kategori Adı *</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $editCategory->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="emoji" class="form-label">Kategori Emojisi *</label>
                        <input type="text" name="emoji" id="emoji" class="form-control" value="{{ old('emoji', $editCategory->emoji) }}" required>
                    </div>
                    
                    <div class="form-group" style="grid-column: span 2;">
                        <label for="description" class="form-label">Açıklama (İsteğe Bağlı)</label>
                        <input type="text" name="description" id="description" class="form-control" value="{{ old('description', $editCategory->description) }}">
                    </div>
                </div>

                <div class="form-card" style="margin-top: 25px; padding: 20px; border: 1px solid #D1D5DB; border-radius: 12px; background-color: #F9FAFB;">
                    <h4 style="font-size: 14.5px; font-weight: 600; color: var(--primary-dark); margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-magnifying-glass"></i> SEO & Arama Motoru Ayarları
                    </h4>
                    
                    <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                        <div class="form-group">
                            <label for="seo_title" class="form-label">SEO Başlığı (Meta Title)</label>
                            <input type="text" name="seo_title" id="seo_title" class="form-control" value="{{ old('seo_title', $editCategory->seo_title) }}" placeholder="Boş bırakılırsa kategori adı kullanılır">
                        </div>
                        <div class="form-group">
                            <label for="seo_description" class="form-label">SEO Açıklaması (Meta Description)</label>
                            <textarea name="seo_description" id="seo_description" class="form-control" rows="2" placeholder="Kategoriye özel meta açıklaması girin...">{{ old('seo_description', $editCategory->seo_description) }}</textarea>
                        </div>
                    </div>

                    <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                        <div class="form-group">
                            <label for="og_title" class="form-label">Sosyal Medya Başlığı (Open Graph Title)</label>
                            <input type="text" name="og_title" id="og_title" class="form-control" value="{{ old('og_title', $editCategory->og_title) }}" placeholder="Boş bırakılırsa SEO başlığı kullanılır">
                        </div>
                        <div class="form-group">
                            <label for="og_description" class="form-label">Sosyal Medya Açıklaması (Open Graph Description)</label>
                            <textarea name="og_description" id="og_description" class="form-control" rows="2" placeholder="Boş bırakılırsa SEO açıklaması kullanılır">{{ old('og_description', $editCategory->og_description) }}</textarea>
                        </div>
                    </div>

                    <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label for="og_image" class="form-label">Paylaşım Görseli (Open Graph Image)</label>
                            <input type="file" name="og_image" id="og_image" class="form-control" accept="image/*">
                            @if($editCategory->og_image)
                                <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
                                    <img src="{{ asset($editCategory->og_image) }}" alt="Mevcut OG Görsel" style="width: 80px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border);">
                                    <span style="font-size: 11px; color: var(--text-muted);">Mevcut Sosyal Paylaşım Görseli</span>
                                </div>
                            @endif
                        </div>
                        <div class="form-group form-checkbox" style="align-items: flex-end; padding-bottom: 15px; margin-top: 0;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <input type="checkbox" name="noindex" id="noindex" value="1" {{ old('noindex', $editCategory->noindex) ? 'checked' : '' }}>
                                <label for="noindex" class="form-label" style="margin-bottom: 0;">Bu Kategoriyi Arama Motorlarında Gizle (noindex)</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div style="margin-top: 20px;">
                    <button type="submit" class="btn-primary" style="border: none; padding: 12px 30px; border-radius: 8px; font-weight: 600; cursor: pointer; background-color: var(--primary); color: white;">
                        Kategoriyi Güncelle
                    </button>
                </div>
            </form>
        </div>

    <!-- Case 2: Create Category -->
    @else
        <div class="form-card" style="margin-bottom: 30px;">
            <h3 style="margin-bottom: 20px; font-size: 16px; font-weight: 600;"><i class="fa-solid fa-circle-plus"></i> Yeni Kategori Ekle</h3>
            
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label for="name" class="form-label">Kategori Adı *</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Örn: Eşek Sütü Sabunları" required value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <label for="emoji" class="form-label">Kategori Emojisi *</label>
                        <input type="text" name="emoji" id="emoji" class="form-control" placeholder="Örn: 🥛" required value="{{ old('emoji') }}">
                    </div>
                    
                    <div class="form-group" style="grid-column: span 2;">
                        <label for="description" class="form-label">Açıklama (İsteğe Bağlı)</label>
                        <input type="text" name="description" id="description" class="form-control" placeholder="Kategoriye ait kısa bir açıklama girin..." value="{{ old('description') }}">
                    </div>
                </div>

                <div class="form-card" style="margin-top: 25px; padding: 20px; border: 1px solid #D1D5DB; border-radius: 12px; background-color: #F9FAFB;">
                    <h4 style="font-size: 14.5px; font-weight: 600; color: var(--primary-dark); margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-magnifying-glass"></i> SEO & Arama Motoru Ayarları
                    </h4>
                    
                    <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                        <div class="form-group">
                            <label for="seo_title" class="form-label">SEO Başlığı (Meta Title)</label>
                            <input type="text" name="seo_title" id="seo_title" class="form-control" value="{{ old('seo_title') }}" placeholder="Boş bırakılırsa kategori adı kullanılır">
                        </div>
                        <div class="form-group">
                            <label for="seo_description" class="form-label">SEO Açıklaması (Meta Description)</label>
                            <textarea name="seo_description" id="seo_description" class="form-control" rows="2" placeholder="Kategoriye özel meta açıklaması girin...">{{ old('seo_description') }}</textarea>
                        </div>
                    </div>

                    <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                        <div class="form-group">
                            <label for="og_title" class="form-label">Sosyal Medya Başlığı (Open Graph Title)</label>
                            <input type="text" name="og_title" id="og_title" class="form-control" value="{{ old('og_title') }}" placeholder="Boş bırakılırsa SEO başlığı kullanılır">
                        </div>
                        <div class="form-group">
                            <label for="og_description" class="form-label">Sosyal Medya Açıklaması (Open Graph Description)</label>
                            <textarea name="og_description" id="og_description" class="form-control" rows="2" placeholder="Boş bırakılırsa SEO açıklaması kullanılır">{{ old('og_description') }}</textarea>
                        </div>
                    </div>

                    <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label for="og_image" class="form-label">Paylaşım Görseli (Open Graph Image)</label>
                            <input type="file" name="og_image" id="og_image" class="form-control" accept="image/*">
                        </div>
                        <div class="form-group form-checkbox" style="align-items: flex-end; padding-bottom: 15px; margin-top: 0;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <input type="checkbox" name="noindex" id="noindex" value="1" {{ old('noindex') ? 'checked' : '' }}>
                                <label for="noindex" class="form-label" style="margin-bottom: 0;">Bu Kategoriyi Arama Motorlarında Gizle (noindex)</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div style="margin-top: 20px;">
                    <button type="submit" class="btn-primary" style="border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; background-color: var(--primary); color: white;">
                        Kategoriyi Kaydet
                    </button>
                </div>
            </form>
        </div>
    @endif

    <div class="table-card">
        <div class="table-header">
            <h3 class="table-title">Mevcut Kategoriler</h3>
        </div>
        
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th style="width: 70px;">Emoji</th>
                        <th>Kategori Adı</th>
                        <th>Slug (URL Yapısı)</th>
                        <th>Açıklama</th>
                        <th>SEO / noindex</th>
                        <th>Ürün Sayısı</th>
                        <th style="text-align: right; width: 180px;">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td style="font-size: 24px; text-align: center;">{{ $category->emoji }}</td>
                            <td style="font-weight: 600; color: var(--primary-dark);">{{ $category->name }}</td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td style="color: var(--text-muted); font-size: 13px;">{{ $category->description ?? '-' }}</td>
                            <td>
                                @if($category->noindex)
                                    <span class="badge" style="background-color: #FDE8E8; color: #9B1C1C;">noindex</span>
                                @else
                                    <span class="badge" style="background-color: #E1EFFE; color: #1E429F;">indekste</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge" style="background-color: #E5F3EB; color: var(--primary-dark); font-weight: 700;">
                                    {{ $category->products_count }} Ürün
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <div class="btn-group" style="justify-content: flex-end;">
                                    <a href="{{ route('admin.categories', ['edit' => $category->id]) }}" class="btn-primary btn-sm" style="text-decoration: none; padding: 6px 12px; font-size: 12px; font-weight: 600; background-color: var(--primary); color: white; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-pen-to-square"></i> Düzenle
                                    </a>
                                    <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST" onsubmit="return confirm('DİKKAT: Bu kategoriyi sildiğinizde bu kategoriye ait TÜM ÜRÜNLER ({{ $category->products_count }} adet) de kalıcı olarak silinecektir! Devam etmek istediğinize emin misiniz?');" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="btn-danger btn-sm" style="border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="fa-solid fa-trash-can"></i> Sil
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
