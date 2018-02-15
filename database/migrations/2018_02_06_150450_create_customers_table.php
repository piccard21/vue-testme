<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateCustomersTable extends Migration {
	
	public function up() {
		Schema::create('customers', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->charset = 'latin1';
			$table->collation = 'latin1_swedish_ci';
			
			$table->increments('id');
			$table->string('promo');
			$table->string('hash')->unique();
			$table->bigInteger('number');
			$table->string('client');
			$table->string('username');
			$table->integer('context');
			$table->string('email');
			$table->boolean('2FA');
			$table->dateTime('end_date');
			$table->timestamps();
		});
	}
	
	public function down() {
		Schema::dropIfExists('customers');
	}
	
}


