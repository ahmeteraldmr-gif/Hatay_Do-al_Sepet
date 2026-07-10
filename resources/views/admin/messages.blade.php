@extends('layouts.admin')

@section('title', 'Gelen Kutusu / Mesajlar')

@section('content')

    <div class="table-card">
        <div class="table-header">
            <h3 class="table-title">İletişim Formu Mesajları</h3>
        </div>
        
        <div class="table-responsive">
            <table style="border-collapse: collapse; width: 100%;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border);">
                        <th style="width: 50px; text-align: center;">Durum</th>
                        <th>Gönderen</th>
                        <th>E-Posta</th>
                        <th>Konu</th>
                        <th>Tarih</th>
                        <th style="text-align: right; width: 220px;">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr style="border-bottom: 1px solid var(--border); {{ !$message->is_read ? 'background-color: rgba(74, 93, 78, 0.03); font-weight: 600;' : '' }}">
                            <td style="text-align: center; vertical-align: middle;">
                                @if(!$message->is_read)
                                    <span style="display: inline-block; width: 10px; height: 10px; background-color: #EF4444; border-radius: 50%;" title="Okunmadı"></span>
                                @else
                                    <span style="display: inline-block; width: 10px; height: 10px; background-color: #9CA3AF; border-radius: 50%;" title="Okundu"></span>
                                @endif
                            </td>
                            <td>{{ $message->name }}</td>
                            <td><a href="mailto:{{ $message->email }}" style="color: var(--primary); text-decoration: none;">{{ $message->email }}</a></td>
                            <td style="color: var(--primary-dark);">{{ $message->subject }}</td>
                            <td style="font-size: 13px; color: var(--text-muted);">{{ $message->created_at->format('d.m.Y H:i') }}</td>
                            <td style="text-align: right; vertical-align: middle;">
                                <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                    <!-- Read full message trigger -->
                                    <button class="btn-primary btn-sm" onclick="viewMessage('{{ $message->id }}', '{{ addslashes($message->name) }}', '{{ $message->email }}', '{{ addslashes($message->subject) }}', '{{ addslashes(str_replace(["\r", "\n"], ["", "<br>"], $message->message)) }}', '{{ $message->created_at->format('d.m.Y H:i') }}')" style="border: none; cursor: pointer; padding: 6px 12px; border-radius: 6px;">
                                        <i class="fa-solid fa-eye"></i> Oku
                                    </button>

                                    <!-- Toggle read status -->
                                    <form action="{{ route('admin.messages.read', $message->id) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="btn-secondary btn-sm" style="border: none; cursor: pointer; padding: 6px 12px; border-radius: 6px;">
                                            @if(!$message->is_read)
                                                <i class="fa-solid fa-check"></i> Okundu Yap
                                            @else
                                                <i class="fa-solid fa-envelope"></i> Okunmadı Yap
                                            @endif
                                        </button>
                                    </form>

                                    <!-- Delete message -->
                                    <form action="{{ route('admin.messages.delete', $message->id) }}" method="POST" onsubmit="return confirm('Bu mesajı silmek istediğinize emin misiniz?');" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="btn-danger btn-sm" style="border: none; cursor: pointer; padding: 6px 12px; border-radius: 6px;">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 30px; color: var(--text-muted);">
                                <i class="fa-solid fa-inbox" style="font-size: 40px; margin-bottom: 10px; display: block; color: var(--border);"></i>
                                Gelen kutunuzda herhangi bir mesaj bulunmamaktadır.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Message Detail Modal -->
    <div id="messageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background-color: white; width: 90%; max-width: 600px; border-radius: 12px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); border: 1px solid rgba(74,93,78,0.1); position: relative;">
            <span onclick="closeModal()" style="position: absolute; top: 15px; right: 15px; font-size: 24px; cursor: pointer; color: var(--text-muted);">&times;</span>
            
            <h3 style="margin-bottom: 20px; font-family: 'Playfair Display', serif; color: var(--primary-dark); font-size: 20px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">
                Mesaj Detayı
            </h3>

            <div style="margin-bottom: 15px; font-size: 14px; color: var(--text-muted); display: grid; grid-template-columns: 80px 1fr; gap: 8px;">
                <strong>Gönderen:</strong> <span id="modalName"></span>
                <strong>E-Posta:</strong> <span id="modalEmail"></span>
                <strong>Konu:</strong> <span id="modalSubject" style="color: var(--primary-dark); font-weight: 600;"></span>
                <strong>Tarih:</strong> <span id="modalDate"></span>
            </div>

            <div style="background-color: var(--bg-cream); border: 1px solid var(--border); border-radius: 8px; padding: 15px; font-size: 15px; line-height: 1.6; color: var(--text-dark); min-height: 150px; max-height: 250px; overflow-y: auto; margin-bottom: 20px;" id="modalMessage">
            </div>

            <div style="text-align: right;">
                <button onclick="closeModal()" class="btn-secondary" style="border: none; cursor: pointer; padding: 10px 24px; border-radius: 8px; font-weight: 600;">
                    Kapat
                </button>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function viewMessage(id, name, email, subject, message, date) {
            document.getElementById('modalName').innerText = name;
            
            // Set email with mailto link
            const emailSpan = document.getElementById('modalEmail');
            emailSpan.innerHTML = `<a href="mailto:${email}" style="color: var(--primary); text-decoration: none; font-weight: 600;">${email}</a>`;
            
            document.getElementById('modalSubject').innerText = subject;
            document.getElementById('modalDate').innerText = date;
            document.getElementById('modalMessage').innerHTML = message;
            
            // Show modal
            document.getElementById('messageModal').style.display = 'flex';

            // Mark as read automatically in the background if it's currently unread
            // By making a POST request or simply reloading the page when they close it.
            // For simple UX, let's keep it simple. If they want to toggle read state they have the button.
        }

        function closeModal() {
            document.getElementById('messageModal').style.display = 'none';
        }

        // Close modal when clicking outside content
        window.onclick = function(event) {
            const modal = document.getElementById('messageModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
@endsection
