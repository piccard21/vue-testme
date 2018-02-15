<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
	        $table->engine = 'InnoDB';
	        $table->charset = 'latin1';
	        $table->collation = 'latin1_swedish_ci';
	        
            $table->increments('id');
	        $table->string('name')->charset('utf8')->collation('utf8_unicode_ci');
	        $table->string('name_ace');
	        $table->string('original');
	        $table->enum('status', ['open', 'selected', 'pending', 'running', 'success', 'error'])->default('open');
	        $table->mediumText('request')->nullable();
	        $table->mediumText('response')->nullable();
	        $table->string('price');
	        $table->integer('customer_id')->unsigned();
	        $table->integer('order_id')->unsigned()->nullable();
            $table->timestamps();
        });
	
	    Schema::table('domains', function($table) {
		    $table->foreign('customer_id')->references('id')->on('customers');
		    $table->foreign('order_id')->references('id')->on('orders');
	    });
	
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domains');
    }
}
