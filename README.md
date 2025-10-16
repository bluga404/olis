# PPW-01-OLIS (Online Library System)

Aplikasi web sederhana untuk manajemen peminjaman buku online, dibangun dengan **Laravel 12**. Proyek ini mendemonstrasikan penggunaan dasar Eloquent ORM, Migrations, Controller, dan Blade untuk membuat sistem CRUD fungsional.

---

## Skema dan Relasi Database

Aplikasi ini menggunakan dua tabel utama: `books` untuk menyimpan informasi buku dan `loans` untuk mencatat transaksi peminjaman.

### Relasi
Relasi yang digunakan adalah **One-to-Many**:
-   Satu `Book` dapat memiliki banyak `Loan`.
-   Satu `Loan` hanya milik satu `Book`.

### Skema Tabel

**1. Tabel `books`**
Tabel ini menyimpan semua data master buku.
-   `id`: Primary Key
-   `title`: Judul buku (string)
-   `author`: Nama penulis (string)
-   `year`: Tahun terbit (year)
-   `status`: Status ketersediaan (`Available`, `Borrowed`)

**2. Tabel `loans`**
Tabel ini berfungsi sebagai catatan transaksi peminjaman.
-   `id`: Primary Key
-   `borrower_name`: Nama peminjam (string)
-   `borrower_nim`: NIM peminjam (string)
-   `book_id`: Foreign Key yang merujuk ke `books.id`
-   `borrowed_at`: Waktu peminjaman (timestamp)
-   `returned_at`: Waktu pengembalian (timestamp, nullable)

---

## Migrations

Struktur database di atas didefinisikan melalui dua file migrasi berikut.

### 1. `create_books_table`
File ini membuat tabel `books`.

-   **Lokasi**: `database/migrations/xxxx_xx_xx_xxxxxx_create_books_table.php`

```php
Schema::create('books', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('author');
    $table->year('year');
    $table->enum('status', ['Available', 'Borrowed'])->default('Available');
    $table->timestamps();
});
```

### 2. `create_loans_table`
File ini membuat tabel `loans` dengan relasi ke tabel `books`.

-   **Lokasi**: `database/migrations/xxxx_xx_xx_xxxxxx_create_loans_table.php`

```php
Schema::create('loans', function (Blueprint $table) {
    $table->id();
    $table->string('borrower_name');
    $table->string('borrower_nim');
    $table->foreignId('book_id')->constrained()->onDelete('cascade');
    $table->timestamp('borrowed_at')->useCurrent();
    $table->timestamp('returned_at')->nullable();
    $table->timestamps();
});
```