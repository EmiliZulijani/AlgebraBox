<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UsersRoot;
use App\Http\Controllers\Auth\RegistrationController;
use Illuminate\Support\Facades\Storage;
use Centaur\AuthManager;
use App\Models\Users;
use Sentinel;


class HomeController extends Controller
{
  /**
   * Set middleware to quard controller.
   *
   * @return void
   */
    public function __construct()
    {
        $this->middleware('sentinel.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$user = Sentinel::getUser()->id;
		
	    $directory = UsersRoot::select('name')->where('user_id', '=' , $user)->get();
		foreach ($directory as $value){
			$dir = $value->name;				
		}
		$existsDir = Storage::disk('local')->allDirectories('public/'.$dir);
		
		
	    if (!empty($file = str_replace('public/'.$dir.'/', '', $existsDir))){

	
		return view('user.home', ['files' => $file]);
		
		} else {
			
		return view('user.home', $message = 'There are no files in directory!');
		
		}
	}
	
	  /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
	 
	 public function create(Request $request)
	 {
		 return view('user.create');
	 }
	 
	 
	 /*
    public function store(Request $request)
    {
  
      $path = $request->file('nam')->store('avatars');

       return $path;
   */

    /**
     * Remove the specified role from storage.
     *
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */

	public function destroy(Request $file)
    {
        Storage::delete($file);
		
		return view ('user.home');

	}
}
