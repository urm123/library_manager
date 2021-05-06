<?php

namespace App\Http\Controllers\Admin;

use App\User; 
use App\Author; 
use App\Repositories\AuthorRepository; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class DashboardController extends Controller
{
    private $author; 

    /**
     * DashboardController constructor. 
     */
    public function __construct()
    { 
        $this->middleware('auth'); 
        $this->author = new AuthorRepository; 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = $this->author->getAuthors(); 
        foreach ($authors as $author) {
            if ($author->deleted_at) {
                $author->deleted = true;
            } else {
                $author->deleted = false;
            }   
        }  

        return view('pages.author.authors', ['authors' => $authors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('pages.author.add-author'); 
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'telephone' => 'required|string|min:10|max:20', 
            'role' => 'required'
        ]);  
        $author = $this->author->createAuthor($request); 

        if($author){
            Session::flash('flash_message', 'Author Added!'); 
            return redirect()->back();
        }else{
            Session::flash('flash_message', 'An error occured!'); 
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
        $user_id = $request->author_id; 
        $author = User::findOrFail($user_id); 

        return response()->json(['author' => $author]); 
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
    public function destroy(Request $request)
    {
        $user_id = $request->user_id; 
        $deactive = $this->author->deactive($user_id);

        if ($deactive) {
            return response()->json([
                'message' => 'success',
                'data' => []
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Request $request)
    {
        $user_id = $request->user_id;
        $restore = $this->author->restore($user_id);
        if ($restore) {
            return response()->json([
                'message' => 'success',
                'data' => []
            ]);
        }
    }
}
