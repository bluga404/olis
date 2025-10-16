{{-- resources/views/library.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Peminjaman Buku - Laravel</title>
    {{-- Direkomendasikan menggunakan Tailwind CSS atau Bootstrap untuk styling --}}
    <style>
        body { font-family: sans-serif; max-width: 1000px; margin: 40px auto; padding: 20px; background-color:#f9fafb; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 25px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border: 1px solid #e5e7eb; text-align: left; }
        th { background-color: #f3f4f6; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, button { width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #d1d5db; box-sizing: border-box; }
        button { background-color: #3b82f6; color: white; cursor: pointer; border: none; }
        .btn-return { background-color: #ef4444; }
        .status-available { color: #16a34a; font-weight: bold; }
        .status-borrowed { color: #dc2626; font-weight: bold; }
        .alert { padding: 15px; background-color: #d1fae5; color: #065f46; border-radius: 5px; margin-bottom: 20px;}
    </style>
</head>
<body>
    <h1>📚 Sistem Peminjaman Buku</h1>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    {{-- Daftar Buku dan Fitur Search --}}
    <div class="card">
        <h2>Daftar Buku</h2>
        <form action="{{ route('books.index') }}" method="GET" style="margin-bottom: 20px; display:flex; gap:10px;">
            <input type="text" name="search" placeholder="Cari judul atau penulis..." value="{{ request('search') }}">
            <button type="submit" style="width: auto;">Cari</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Tahun</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->year }}</td>
                        <td>
                            <span class="status-{{ strtolower($book->status) }}">
                                {{ $book->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Tidak ada buku ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Form Peminjaman --}}
    <div class="card">
        <h2>Form Peminjaman</h2>
        <form action="{{ route('books.borrow') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="borrower_name">Nama Peminjam</label>
                <input type="text" id="borrower_name" name="borrower_name" required>
            </div>
            <div class="form-group">
                <label for="borrower_nim">NIM</label>
                <input type="text" id="borrower_nim" name="borrower_nim" required>
            </div>
            <div class="form-group">
                <label for="book_id">Judul Buku</label>
                <select id="book_id" name="book_id" required>
                    <option value="">-- Pilih Buku --</option>
                    @foreach($availableBooks as $book)
                        <option value="{{ $book->id }}">{{ $book->title }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit">Pinjam Buku</button>
        </form>
    </div>
    
    {{-- Daftar Pinjaman Aktif --}}
    <div class="card">
        <h2>Buku Sedang Dipinjam</h2>
        <table>
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Peminjam</th>
                    <th>NIM</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activeLoans as $loan)
                <tr>
                    <td>{{ $loan->book->title }}</td>
                    <td>{{ $loan->borrower_name }}</td>
                    <td>{{ $loan->borrower_nim }}</td>
                    <td>
                        <form action="{{ route('books.return', $loan) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-return">Return Book</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">Tidak ada buku yang sedang dipinjam.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>