<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrower_name',
        'borrower_nim',
        'book_id',
        'borrowed_at',
        'returned_at',
    ];

    // Relasi: Satu peminjaman pasti milik satu buku
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
