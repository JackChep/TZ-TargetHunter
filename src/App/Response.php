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

        if(isset($data->items)) {
            $this->items = !isset($data->items) ? false : $data->items;
        }

        $this->count = !isset($data->count) ? false : $data->count;

        if (is_array($data)) {
            $this->count = count($data);
            $this->data = $data;
        }
    }

    public function getCount(){
        return count($this->items);
    }

    
    public function getById($id = false)
    {
        if (!$id) {
            if (is_array($this->data)) {
                return $this->data[0];
            } elseif (isset($this->items) && $this->items !== false) {
                return $this->items[0];
            } else {
                return $this->data;
            }
        } else {
            return $this->data[$id];
        }
    }



}