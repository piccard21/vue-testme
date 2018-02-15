<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Customer extends Model {
	
	protected $fillable = ['promo', 'number', 'client', 'username', 'context', 'email', '2FA', 'end_date', 'created_at', 'updated_at'];
	
	
	public function domains() {
		return $this->hasMany('App\Domain');
	}
}
