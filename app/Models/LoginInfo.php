<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginInfo extends Model
{
    protected $table = 'login_info';

	protected $fillable = [
		'activity',
		'user_id',
		'username',
		'remarks',
		'ip_address',
		'device',
		'platform',
		'browser',
	];

	public function user()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}
}
