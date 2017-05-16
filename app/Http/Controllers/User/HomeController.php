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
	
	private $user_id;
	private $root_name = false;
	
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
		$this->setRoot();
		
		
		if($this->root_name) {
			$allDir = Storage::disk('public')->directories($this->root_name);
			$files = Storage::disk('public')->files($this->root_name);
			
			return view('user.home', ['directories' => $allDir, 'files' => $files]);
		}
		
		return view('user.home',['directories' => false, 'files' => false]);
		
	}
	
	  /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
	 
	public function create(Request $request)
	{
		$this->setRoot();	
		$dir_name = trim($request->get('dir_name'));
        if(!empty($dir_name)) {
			Storage::disk('public')->makeDirectory($this->root_name.'/'.$dir_name);
			session()->flash ('success', "You have successfully created new folder {$dir_name}");
		}
		
		return redirect()->route('home');
	}

	
	public function show($name, $name1=null, $name2=null)
	{
		if ($name2){{
		$bc=array($name, $name1, $name2);
		}
		if ($name1){
		$bc=array($name, $name1);
		}}
		$bc=array($name);
		
        $this->setRoot(); 
		
        $path = $this->root_name.'/'.$name;
        $directories = Storage::disk('public')->directories($path);
        $files = Storage::disk('public')->files($path);
        return view('user.show',['directories' => $directories, 'files' => $files, 'bc' => $bc]);
	}
 
  
	 	public function delete($name)
    {
       
		$this->setRoot();
	   
		Storage::disk('public')->deleteDirectory($this->root_name.'/'.$name);
		Storage::disk('public')->delete($this->root_name.'/'.$name);
		session()->flash ('success', "You have successfully deleted folder {$name}");
		return redirect()->route('home');	
	}
	 	
	

	 	private function setRoot()
	{	
		$this->user_id = Sentinel::getUser()->id;
		$root = UsersRoot::where('user_id', $this->user_id)->first();
		if($root) {
			$this->root_name = $root->name;
		}else {
			session()->flash('error', 'Cannot find user root directory');
		}
	
	}

}
	

	
	

########### MOJI PRIMJERI ###########
/*
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
	
		 public function create(Request $request)
	 {
		 
		 return view('user.create');
	 }
	 
		
			foreach ($directories as $directory){
			
			$subDir = Storage::allDirectories($directory);
			$subFile = Storage::allFiles($directory);
			
			return view('user.home', ['directories' => $subDir, 'files' => $subFile]);			
		}
			
		return view('user.home',['directories' => false, 'files' => false]);
	
	
	
	*/