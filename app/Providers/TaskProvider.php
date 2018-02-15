<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Lib\Data\TaskQuery;

class TaskProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
	    $this->app->singleton(TaskQuery::class, function($app, $parameters) {
		    return new TaskQuery(env('TASK_URL'),$parameters['user'],$parameters['password'],$parameters['context']);
	    });
    }
}
