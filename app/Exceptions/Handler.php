<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {
	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		//
	];
	
	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'password',
		'password_confirmation',
	];
	
	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception $exception
	 * @return void
	 */
	public function report(Exception $exception) {
		parent::report($exception);
	}
	
	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Exception $exception
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $exception) {
		// exception while ajax
		if($request->ajax() || $request->wantsJson()) {
			$msg = !empty($exception->getMessage()) ? $exception->getMessage() : get_class($exception);
			
			// expose in production a standard-message
			if(env('APP_ENV') === 'live') {
				$msg = 'Sorry ... an error occured';
			}
			
			$response = array(
				'success' => false,
				'msg' => $msg
			);
			$status = 200;
			return response()->json($response, $status);
		}
		
		return parent::render($request, $exception);
	}
}
