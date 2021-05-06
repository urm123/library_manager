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
        // Middleware already applied to the route. why do you do same thing in here ?
        $this->middleware('auth'); 
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
        foreach ($books as $book) {
            if ($book->deleted_at) {
                $book->deleted = true; // whats this ?
            } else {
                $book->deleted = false; // whats this ?
            }   
        }  

        return view('pages.books.books', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('pages.books.add-new-book'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // move validations to the seperate requiret file
        
        $this->validate($request, [ 
            'book_name' => 'required|string|max:255',
            'published_date' => 'required|string|max:255' 
        ]);  

        $author_id = Auth::user()->id; 
        $author = User::findOrFail($author_id); 
        if($author['is_active'] == 1){ 
            // dont do it here. you can move this $checkIfExist is to the validations
            
            $checkIfExist = Books::where('author', '=', $author_id)->where('book_name', '=', $request->book_name)->first();
            if ($checkIfExist === null) { 
                $request->request->set('author', $author_id);
                $book = $this->books->createNewBook($request); 

                if($book){
                    Session::flash('flash_message', 'Book Added!'); 
                    return redirect()->back();
                    
                    // you can do that in single line like
                    // return redirect()->route('category.index')->withFlashSuccess('category created.'); or
                    // return redirect()->back()->withFlashDanger('Error. Something went wrong.');
                    
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
        $book_id = $request->book_id; // not required because no reuse. just do like $request->book_id pass to the findOrFail
        $book = Books::findOrFail($book_id); 

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
        $book_id = $request->book_id; 
        $book = Books::findOrFail($book_id); 

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
        $book = Books::findOrFail($request->id);   
        $this->validate($request, [
            'book_name' => 'required|max:255',
            'published_date' => 'required|max:255'
        ]);   

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
        $book_id = $request->book_id; 
        $remove = $this->book_id->deleteBook($book_id); // whats this ? this will work ? how can you call function using varialble ?

        if ($remove) {
            return response()->json([
                'message' => 'success',
                'data' => []
            ]);
        }
    } 
}
