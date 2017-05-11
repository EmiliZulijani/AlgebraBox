<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersRoot extends Model
{
	protected $table = 'users_root';

	public function user()
	{
		return $this->belongsTo('App\Models\Users', 'user_id', 'id');
	}
	
}
