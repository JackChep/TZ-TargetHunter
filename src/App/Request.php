<?php

namespace App;

class Request{


    const URL_VK_API = 'https://api.vk.com/method/';

    private $methodName = false;
    private $connectVK = false;
    private $idCommunity = false;
    private $params = [];

    
    public function __construct($connectVK, $methodName, $idCommunity, $args = false)
    {
        
        if (is_array($args)) {
            $this->params($args);
        }

        $this->connectVK = $connectVK;
        $this->methodName = $methodName;
        $this->idCommunity = $idCommunity;
        
    }

    public function buildRequestParams(){

        $requestParams = [
            'v' => $this->connectVK->getVersion(),
            'access_token' => $this->connectVK->getToken(),
        ];
        $requestParams = array_merge($this->params, $requestParams);
        
        $requestParams = http_build_query($requestParams);

        return $requestParams;  
    }

    
    public function param($key, $value, $defaultValue = false)
    {
        if (!$value && $defaultValue) {
            $value = $defaultValue;
        }

        $this->params[$key] = $value;

        return $this;
    }

    public function params(array $data)
    {
        foreach ($data as $k => $v) {
            $this->param($k, $v);
        }

        return $this;
    }






}