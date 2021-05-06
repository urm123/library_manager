<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Auth; 
use App\Books; 
use App\Author; 
use App\Repositories\BooksRepository; 
use App\Repositories\AuthorRepository; 

class BookUserController extends Controller
{
    private $author; 
    private $books;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth'); 
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
        return view('pages.landing');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchRelatedBooks(Request $request)
    {
        $keyword = $request->keyword; 
        $books = $this->books->searchBooks($keyword); 
        $authors = $this->author->searchAuthors($keyword);  
        $suggestions = $books->merge ($authors);   

        if(!$suggestions->isEmpty()){
            foreach ($suggestions as $suggestion) {
                if ($suggestion->first_name) { 
                    $suggestion->suggest_name = $suggestion->first_name .' '. $suggestion->last_name; 
                }
                if ($suggestion->book_name) { 
                    $suggestion->suggest_name = $suggestion->book_name; 
                }
            } 
            $success = TRUE; 
        }else{
            $success = FALSE; 
        }

        return response()->json([
            'success' => $success,
            'suggestions' => $suggestions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
