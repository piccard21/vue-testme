<?php

namespace App\Exceptions;

use Exception;

class TaskException extends Exception {
	public function __construct($message, $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
	
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
	
	public function customFunction() {
		echo "Hmmm ... we could do something in here\n";
	}
}