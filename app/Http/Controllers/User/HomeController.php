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
	 
	 
	public function create(Request $request, $sublevels=null)
	{
		$this->setRoot();
		$dir_name = trim($request->get('dir_name'));
		
	   
	   if (!empty($sublevels)) {
            $sublevels = explode('/', $sublevels);
			
        $uri = '';
            foreach ($sublevels as $sublevel) {
                $uri .= $sublevel.'/';
            };
        }else {
            $uri = null;
        }	
		
        if(!empty($dir_name && !$uri)) {
			Storage::disk('public')->makeDirectory($this->root_name.'/'.$dir_name);
            session()->flash('success', 'You have successfully created a new folder');
            return redirect()->route('home');
		} else{
		    Storage::disk('public')->makeDirectory($this->root_name.'/'.$uri.'/'.$dir_name);
            session()->flash('success', 'You have successfully created a new folder');
            return redirect()->back();
		}
	}

	
	public function show($name, $sublevels=null)
	{
		$this->setRoot();
        if (!empty($sublevels)) {
            $sublevels = explode('/', $sublevels);
        $uri = '';
            foreach ($sublevels as $sublevel) {
                $uri .= $sublevel.'/';
            }
        $bc = $sublevels;
        array_unshift($bc, $name);
        }else {
            $uri = null;
            $bc = array($name);
        }
        $path = $this->root_name.'/'.$name.'/'.$uri;
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
	 	
	public function upload (Request $request)
	{
		$this->setRoot();
		
		if ($request->file()){
			
			foreach ($request->file() as $files){
				foreach($files as $file){
					$file->storeAs('public/'.$this->root_name, $file->getClientOriginalName());
				}
			}
		session()->flash ('success', "You have successfully upload file");
		return redirect()->route('home');
		
		}
		
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