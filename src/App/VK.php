<?php

namespace App;

class VK{

    
    private $version = false;
    private $accessToken = false;

    
    public function __construct($accessToken = false, $version = false )
    {
        $this->version = $version;
        $this->accessToken = $accessToken;
    }

    public function getToken()
    {
        return $this->accessToken;
    }

    
    public function getVersion()
    {
        return $this->version;
    }
    
    public function setToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    
    public function setVersion($version)
    {
        $this->version = $version;
    }

}