@extends('layouts.admin')

@section('title', 'Ürün Yönetimi')

@section('content')

    <!-- Case 1: Edit Product -->
    @if(isset($editProduct))
        <div class="table-card" style="padding: 24px;">
            <div class="table-header" style="border-bottom: none; padding: 0 0 20px 0;">
                <h3 class="table-title">Ürün Düzenle: {{ $editProduct->name }}</h3>
                <a href="{{ route('admin.products') }}" style="font-size: 14px; text-decoration: underline; color: var(--text-muted);">
                    <i class="fa-solid fa-arrow-left"></i> Ürün Listesine Dön
                </a>
            </div>

            <form action="{{ route('admin.products.update', $editProduct->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name" class="form-label">Ürün Adı *</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $editProduct->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="category_id" class="form-label">Kategori *</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">Kategori Seçin</option>
                            @foreach(\App\Models\Category::all() as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $editProduct->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price" class="form-label">Fiyat (TL) *</label>
                        <input type="number" name="price" id="price" class="form-control" step="0.01" min="0" value="{{ old('price', $editProduct->price) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="image" class="form-label">Ürün Görseli (Boş bırakırsanız mevcut görsel kalır)</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        @if($editProduct->image_path)
                            <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
                                <img src="{{ asset($editProduct->image_path) }}" alt="Mevcut Görsel" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border);">
                                <span style="font-size: 12px; color: var(--text-muted);">Mevcut Görsel</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Açıklama *</label>
                    <textarea name="description" id="description" class="form-control" required>{{ old('description', $editProduct->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="ingredients" class="form-label">İçindekiler / Bileşenler</label>
                    <textarea name="ingredients" id="ingredients" class="form-control">{{ old('ingredients', $editProduct->ingredients) }}</textarea>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="benefits" class="form-label">Faydaları</label>
                        <textarea name="benefits" id="benefits" class="form-control">{{ old('benefits', $editProduct->benefits) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="usage" class="form-label">Kullanım Şekli</label>
                        <textarea name="usage" id="usage" class="form-control">{{ old('usage', $editProduct->usage) }}</textarea>
                    </div>
                </div>

                <div class="form-group form-checkbox" style="margin-top: 10px;">
                    <input type="checkbox" name="in_stock" id="in_stock" value="1" {{ old('in_stock', $editProduct->in_stock) ? 'checked' : '' }}>
                    <label for="in_stock" class="form-label" style="margin-bottom: 0;">Ürün Stokta Var</label>
                </div>

                <div style="margin-top: 30px;">
                    <button type="submit" class="btn-primary" style="border: none; padding: 12px 30px; border-radius: 8px; font-weight: 600; cursor: pointer; background-color: var(--primary); color: white;">
                        Değişiklikleri Kaydet
                    </button>
                </div>
            </form>
        </div>

    <!-- Case 2: Create Product -->
    @elseif(request()->has('create'))
        <div class="table-card" style="padding: 24px;">
            <div class="table-header" style="border-bottom: none; padding: 0 0 20px 0;">
                <h3 class="table-title">Yeni Doğal Sabun Ekle</h3>
                <a href="{{ route('admin.products') }}" style="font-size: 14px; text-decoration: underline; color: var(--text-muted);">
                    <i class="fa-solid fa-arrow-left"></i> Ürün Listesine Dön
                </a>
            </div>

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name" class="form-label">Ürün Adı *</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Örn: Hakiki Zeytinyağlı Defne Sabunu" required>
                    </div>

                    <div class="form-group">
                        <label for="category_id" class="form-label">Kategori *</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">Kategori Seçin</option>
                            @foreach(\App\Models\Category::all() as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price" class="form-label">Fiyat (TL) *</label>
                        <input type="number" name="price" id="price" class="form-control" step="0.01" min="0" placeholder="95.00" value="{{ old('price') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="image" class="form-label">Ürün Görseli *</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Açıklama *</label>
                    <textarea name="description" id="description" class="form-control" placeholder="Sabunun üretim şeklini ve genel bilgilerini yazın..." required>{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="ingredients" class="form-label">İçindekiler / Bileşenler</label>
                    <textarea name="ingredients" id="ingredients" class="form-control" placeholder="Örn: Zeytinyağı, defne yağı, su, sabun mayası...">{{ old('ingredients') }}</textarea>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="benefits" class="form-label">Faydaları</label>
                        <textarea name="benefits" id="benefits" class="form-control" placeholder="Örn: Saç dökülmesini ve kepeklenmeyi önlemeye yardımcı olur...">{{ old('benefits') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="usage" class="form-label">Kullanım Şekli</label>
                        <textarea name="usage" id="usage" class="form-control" placeholder="Örn: Islak cilde dairesel hareketlerle masaj yaparak uygulayın...">{{ old('usage') }}</textarea>
                    </div>
                </div>

                <div class="form-group form-checkbox" style="margin-top: 10px;">
                    <input type="checkbox" name="in_stock" id="in_stock" value="1" checked>
                    <label for="in_stock" class="form-label" style="margin-bottom: 0;">Ürün Stokta Var</label>
                </div>

                <div style="margin-top: 30px;">
                    <button type="submit" class="btn-primary" style="border: none; padding: 12px 30px; border-radius: 8px; font-weight: 600; cursor: pointer; background-color: var(--primary); color: white;">
                        Ürünü Kaydet
                    </button>
                </div>
            </form>
        </div>

    <!-- Case 3: List Products -->
    @else
        <div class="table-card">
            <div class="table-header">
                <h3 class="table-title">Doğal Sabun Ürünlerimiz</h3>
                <a href="{{ route('admin.products', ['create' => 1]) }}" class="btn-primary" style="text-decoration: none; padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; background-color: var(--primary); color: white;">
                    <i class="fa-solid fa-plus"></i> Yeni Ürün Ekle
                </a>
            </div>
            
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 80px;">Görsel</th>
                            <th>Ürün Adı</th>
                            <th>Kategori</th>
                            <th>Fiyat</th>
                            <th>Stok Durumu</th>
                            <th style="text-align: right; width: 180px;">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($products->isEmpty())
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">
                                    Henüz ürün eklenmemiş.
                                </td>
                            </tr>
                        @else
                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        @if($product->image_path)
                                            <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border);">
                                        @else
                                            <div style="width: 50px; height: 50px; border-radius: 8px; background-color: var(--primary-light); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                                {{ mb_substr($product->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td style="font-weight: 600; color: var(--primary-dark);">
                                        {{ $product->name }}
                                    </td>
                                    <td>
                                        <span class="badge" style="background-color: #F3F4F6; color: var(--text-dark); border: 1px solid var(--border);">
                                            {{ $product->category->name }}
                                        </span>
                                    </td>
                                    <td style="font-weight: 700; color: var(--text-dark);">
                                        {{ number_format($product->price, 2) }} TL
                                    </td>
                                    <td>
                                        @if($product->in_stock)
                                            <span class="badge badge-success">Stokta Var</span>
                                        @else
                                            <span class="badge badge-danger">Stokta Yok</span>
                                        @endif
                                    </td>
                                    <td style="text-align: right;">
                                        <div class="btn-group" style="justify-content: flex-end;">
                                            <!-- Stock status toggle -->
                                            <form action="{{ route('admin.products.toggle-stock', $product->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn-secondary btn-sm" title="Stok Durumunu Değiştir" style="cursor: pointer; background: white;">
                                                    <i class="fa-solid fa-rotate"></i>
                                                </button>
                                            </form>
                                            
                                            <!-- Edit -->
                                            <a href="{{ route('admin.products', ['edit' => $product->id]) }}" class="btn-secondary btn-sm" title="Düzenle" style="background: white;">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            
                                            <!-- Delete -->
                                            <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bu ürünü silmek istediğinize emin misiniz? Bu işlem geri alınamaz!');">
                                                @csrf
                                                <button type="submit" class="btn-danger btn-sm" title="Sil" style="border: none; cursor: pointer;">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            
            @if($products->hasPages())
                <div style="padding: 20px 24px; border-top: 1px solid var(--border); display: flex; justify-content: center;">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    @endif

@endsection
