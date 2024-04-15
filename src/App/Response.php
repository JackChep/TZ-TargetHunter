<?php

namespace App;

class Response{


    public $data = false;
    public $items = false;
    public $count = false;
    public $error = false;

    public function __construct($data)
    {
        $this->error = !isset($data->error) ? false : new Error($data->error);
        $data = $data->response;
        if (is_array($data)){
            foreach ($data as $key => $value) {
                if (property_exists($this, $key)) {
                    continue;
                }
                $this->{$key} = $value;
            }
        }
        if (is_array($data) || !isset($data->items)) {
            $this->count = count($data);
            $this->data = $data;
        }else{
            if (is_array($data->items) || !is_array($data->items[0])) {
                foreach ($data->items as $key => $value) {
                    $this->items[] = [$value];
                }
            }else{
                $this->items = !isset($data->items) ? false : $data->items;
            }
        }
        $this->count = !isset($data->count) ? false : $data->count;


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