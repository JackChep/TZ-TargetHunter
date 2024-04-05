<?php

namespace App;

class Response{


    public $data = false;
    public $items = false;
    public $count = false;
    private $extendedFields = [];
    public $error = false;

    public function __construct($data)
    {
        $this->error = !isset($data->error) ? false : new Error($data->error);
        
        $data = $data->response;

        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                continue;
            }
            $this->{$key} = $value;
        }
        //echo isset($data->items);
        //var_dump($this);
        $this->items = !isset($data->items) ? false : $data->items;
        

        $this->count = !isset($data->count) ? false : $data->count;

        if (is_array($data) || !isset($data->items)) {
            $this->count = count($data);
            $this->data = $data;
        }

    }

    public function getCountItems(){
        return count($this->items);
    }

    public function getCount(){
        return count($this->items);
    }

    
    public function getById($id = false)
    {
        if (!$id) {
            if (isset($this->items) && $this->items !== false) {
                return $this->items[0];
            }
        }
    }



}