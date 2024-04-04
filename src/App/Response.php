<?php

namespace App;

class Response{


    public $data = false;
    public $items = false;
    public $count = false;

    public function __construct($data, $callback = false)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                continue;
            }

            $this->{$key} = $value;
        }

        $this->count = !isset($data->count) ? false : $data->count;

        if (is_array($data)) {
            $this->count = count($data);
            $this->data = $data;
        }
    }



}