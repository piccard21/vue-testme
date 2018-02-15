<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model {
	
	protected $fillable = ['name', 'name_ace', 'original', 'status', 'request', 'response', 'price', 'order_id', 'customer_id', 'created_at', 'updated_at'];
	
	
	public function customer() {
		return $this->belongsTo('App\Customer');
	}
}
