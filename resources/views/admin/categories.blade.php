@extends('layouts.admin')

@section('title', 'Kategori Yönetimi')

@section('content')

    <div class="form-card" style="margin-bottom: 30px;">
        <h3 style="margin-bottom: 20px; font-size: 16px; font-weight: 600;"><i class="fa-solid fa-circle-plus"></i> Yeni Kategori Ekle</h3>
        
        <form action="{{ route('admin.categories.store') }}" method="POST">
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
            
            <div style="margin-top: 15px;">
                <button type="submit" class="btn-primary" style="border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; background-color: var(--primary); color: white;">
                    Kategoriyi Kaydet
                </button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="table-header">
            <h3 class="table-title">Mevcut Kategoriler</h3>
        </div>
        
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th style="width: 80px;">Emoji</th>
                        <th>Kategori Adı</th>
                        <th>Slug (URL Yapısı)</th>
                        <th>Açıklama</th>
                        <th>Ürün Sayısı</th>
                        <th style="text-align: right; width: 120px;">İşlemler</th>
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
                                <span class="badge" style="background-color: #E5F3EB; color: var(--primary-dark); font-weight: 700;">
                                    {{ $category->products_count }} Ürün
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST" onsubmit="return confirm('DİKKAT: Bu kategoriyi sildiğinizde bu kategoriye ait TÜM ÜRÜNLER ({{ $category->products_count }} adet) de kalıcı olarak silinecektir! Devam etmek istediğinize emin misiniz?');">
                                    @csrf
                                    <button type="submit" class="btn-danger btn-sm" style="border: none; cursor: pointer;" title="Sil">
                                        <i class="fa-solid fa-trash-can"></i> Sil
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
