@extends('layouts.admin')

@section('title', 'Yorum Yönetimi')

@section('content')

    <div class="table-card">
        <div class="table-header">
            <h3 class="table-title">Ürün Değerlendirmeleri & Yorumlar</h3>
        </div>
        
        <div class="table-responsive">
            <table style="border-collapse: collapse; width: 100%;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border);">
                        <th>Ürün</th>
                        <th>Yorum Yapan</th>
                        <th style="width: 130px;">Puan</th>
                        <th>Yorum</th>
                        <th style="width: 140px;">Tarih</th>
                        <th style="text-align: right; width: 100px;">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr style="border-bottom: 1px solid var(--border);">
                            <td style="font-weight: 600; color: var(--primary-dark);">
                                @if($review->product)
                                    <a href="{{ route('products.show', $review->product->slug) }}" target="_blank" style="color: var(--primary-dark); text-decoration: none; display: flex; align-items: center; gap: 8px;">
                                        @if($review->product->image_path)
                                            <img src="{{ asset($review->product->image_path) }}" style="width: 32px; height: 32px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border);">
                                        @endif
                                        {{ $review->product->name }}
                                    </a>
                                @else
                                    <span style="color: var(--text-muted); font-style: italic;">Silinmiş Ürün</span>
                                @endif
                            </td>
                            <td>{{ $review->name }}</td>
                            <td>
                                <div style="display: flex; gap: 2px; color: #FBBF24;">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fa-solid fa-star"></i>
                                        @else
                                            <i class="fa-regular fa-star" style="color: #D1D5DB;"></i>
                                        @endif
                                    @endfor
                                </div>
                            </td>
                            <td style="font-size: 14px; max-width: 350px; white-space: normal; word-break: break-all; line-height: 1.5;">
                                {{ $review->comment }}
                            </td>
                            <td style="font-size: 13px; color: var(--text-muted);">
                                {{ $review->created_at->format('d.m.Y H:i') }}
                            </td>
                            <td style="text-align: right; vertical-align: middle;">
                                <form action="{{ route('admin.reviews.delete', $review->id) }}" method="POST" onsubmit="return confirm('Bu yorumu silmek istediğinize emin misiniz? Bu işlem geri alınamaz!');" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="btn-danger btn-sm" style="border: none; cursor: pointer; padding: 8px 12px; border-radius: 6px;" title="Yorumu Sil">
                                        <i class="fa-solid fa-trash-can"></i> Sil
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                <i class="fa-regular fa-comment-dots" style="font-size: 44px; margin-bottom: 12px; display: block; color: var(--border);"></i>
                                Henüz hiçbir ürün için yorum yapılmamış.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reviews->hasPages())
            <div style="padding: 15px 20px; border-top: 1px solid var(--border); display: flex; justify-content: center;">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>

@endsection
