<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Loan;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();
        if($request->has('search') && $request->search != ''){
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")->orWhere('author', 'like', "%{$search}%");
        }
        $books = $query->orderBy("title")->get();

        $availableBooks = Book::where('status', 'Available')->orderBy('title')->get();

        $activeLoans = Loan::whereNull('returned_at')->with('book')->get();

        return view('library', [
            'books' => $books,
            'availableBooks' => $availableBooks,
            'activeLoans' => $activeLoans,
        ]);
    }

    public function borrow(Request $request)
    {
        $request->validate([
            'borrower_name' => 'required|string|max:255',
            'borrower_nim' => 'required|string|max:20',
            'book_id' => 'required|exists:books,id',
        ]);

        // Buat record pinjaman baru
        Loan::create([
            'borrower_name' => $request->borrower_name,
            'borrower_nim' => $request->borrower_nim,
            'book_id' => $request->book_id,
        ]);

        // Update status buku menjadi 'Borrowed'
        $book = Book::find($request->book_id);
        $book->status = 'Borrowed';
        $book->save();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dipinjam!');
    }

    public function return(Loan $loan)
    {
        // Update record pinjaman dengan waktu pengembalian
        $loan->returned_at = now();
        $loan->save();

        // Update status buku kembali menjadi 'Available'
        $book = $loan->book;
        $book->status = 'Available';
        $book->save();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dikembalikan!');
    }
}
