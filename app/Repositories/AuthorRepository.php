<?php 
namespace App\Repositories;

use App\User;
use App\Constants\AppConstant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BooksRepository
 * @package App\Repositories
 */
class AuthorRepository
{
    /**
     * @return mixed
     */
    public function getAuthors() : object {  
        return User::where('role_id', '=', AppConstant::AUTHOR_ROLE)->get();
    }

    /** 
     * @param $request
     * @return Author
     */
    // need to add data type and return type for each and every functions
    public function createAuthor($request)
    {
        $user = New User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->telephone = $request->telephone;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->role;
        $user->save(); 
        return $user;
    }

    /**
     * @param int $user_id
     * @return mixed
     */
    public function deactive($user_id)
    {
        return User::whereId($user_id)->update([
            'is_active' => 0
        ]);
    }

    /**
     * @param int $user_id
     * @return mixed
     */
    public function restore($user_id)
    {
        return User::whereId($user_id)->update([
            'is_active' => 1
        ]);
    }

    /**
     * @param String $keyword
     * @return Collection
     */
    public function searchAuthors(String $keyword) : Collection {   
        return $authors = User::where ('first_name', 'like', '%'. $keyword. '%')
        ->where('role_id', '=', AppConstant::AUTHOR_ROLE)->get(); 
    } 
}
