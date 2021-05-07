<?php

namespace App\Http\Controllers\Author;

use Auth;
use App\User; 
use App\Books; 
use App\Author; 
use App\Repositories\BooksRepository; 
use App\Repositories\AuthorRepository; 
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Validator;
use Session;

class DashboardController extends Controller
{
    private $author; 
    private $books; 

    /**
     * DashboardController constructor. 
     */
    public function __construct()
    {  
        $this->author = new AuthorRepository; 
        $this->books = new BooksRepository; 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $author_id = Auth::user()->id; 
        $books = $this->books->getAuthorBooks($author_id);   

        return view('pages.backend.books.books', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('pages.backend.books.add-new-book'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [ 
            'book_name' => 'required|string|max:255',
            'published_date' => 'required|string|max:255' 
        ]);  

        $author_id = Auth::user()->id; 
        $author = User::findOrFail($author_id); 
        if($author['is_active'] == 1){ 
            $checkIfExist = Books::where('author', '=', $author_id)->where('book_name', '=', $request->book_name)->first();
            if ($checkIfExist === null) { 
                $request->request->set('author', $author_id);
                $book = $this->books->createNewBook($request); 

                if($book){
                    Session::flash('flash_message', 'Book Added!'); 
                    return redirect()->back();
                }else{
                    Session::flash('flash_error_message', 'An error occured!'); 
                    return redirect()->back();
                }
            }else{
                Session::flash('flash_error_message', 'Record Exist!'); 
                return redirect()->back();
            }
        }else{
            Session::flash('flash_error_message', 'Your account is deactivated!'); 
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    { 
        $book = Books::findOrFail($request->book_id);  
        return response()->json(['book' => $book]); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    { 
        $book = Books::findOrFail($request->book_id);  
        return response()->json(['book' => $book]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        $this->validate($request, [
            'book_name' => 'required|max:255',
            'published_date' => 'required|max:255'
        ]);    
        $book = Books::findOrFail($request->id); 
        $input = $request->all(); 
        $book->fill($input)->save(); 

        Session::flash('flash_message', 'Book Updated!'); 
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    { 
        $remove = $this->book_id->deleteBook($request->book_id);

        if ($remove) {
            return response()->json([
                'message' => 'success',
                'data' => []
            ]);
        }
    } 
}
