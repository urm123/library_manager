<?php 
namespace App\Repositories;

use App\Books;  
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BooksRepository
 * @package App\Repositories
 */
class BooksRepository
{
    /**
     * @param int $author_id
     * @return Collection
     */
    public function getAuthorBooks(int $author_id) : Collection {
        return Books::where('author', '=', $author_id)->get();
    }

    /** 
     * @param  \Illuminate\Http\Request  $request
     * @return Author
     */
    public function createNewBook(Request $request)
    {
        $book = New Books();
        $book->book_name = $request->book_name;
        $book->published_date = $request->published_date; 
        $book->author = $request->author;
        $book->save(); 
        return $book;
    }

    /**
     * @param int $book_id
     * @return mixed
     */
    public function deleteBook(int $book_id)
    {
        return Books::where('id', '=', $book_id)->delete();
    } 

    /**
     * @param String $keyword
     * @return Collection
     */
    public function searchBooks(String $keyword) : Collection {  
        return $books = Books::where('book_name', 'like', '%'. $keyword. '%')->get();  
    }  
}