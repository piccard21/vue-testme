<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
	protected $fillable = ['customer_id', 'created', 'status ', 'order_backend_session', 'created_at', 'updated_at'];
}
