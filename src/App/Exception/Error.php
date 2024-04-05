<?php

namespace App\Exception;

use Exception;

class Error extends Exception
{
    public $error = false;

    public function __construct($message, $code, \App\Error $e)
    {
        $this->error = $e;
        $this->message = $message;
        $this->code = $code;
    }
}