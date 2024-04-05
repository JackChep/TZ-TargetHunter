<?php

namespace App;


class Error 
{
    public $error_msg;
    public $error_code;
    public $request_params = [];

    public function __construct($error)
    {
        foreach ($error as $k => $v) {
            $this->{$k} = $v;
        }
        throw new Exception\Error($error->error_msg, $error->error_code, $this);
    }

    public function getCode()
    {
        return $this->error_code;
    }

    public function getMessage()
    {
        return $this->error_msg;
    }

    public function getRequestParams()
    {
        return $this->request_params;
    }
}