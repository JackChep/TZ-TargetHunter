<?php

namespace App;

class Request{


    const URL_VK_API = 'https://api.vk.com/method/';

    private $methodName = false;
    private $connectVK = false;
    private $params = [];
	public $membersGroups = array();

    
    public function __construct(\App\VK $connectVK, $methodName, $args = false)
    {
        
        if (is_array($args)) {
            $this->params($args);
        }

        $this->connectVK = $connectVK;
        $this->methodName = $methodName;
        
    }

    public function buildRequestParams($opt = false)
    {

        $requestParams = [
            'v' => $this->connectVK->getVersion(),
            'access_token' => $this->connectVK->getToken(),
        ];

        if(isset($opt)){
            if (is_array($opt)) {
                //$this->params($opt);
                $requestParams = array_merge($opt, $requestParams);
            }
        }


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

    public function sending($methodName = false, $opt = false){

        $methodName = !empty($methodName) ? $methodName : $this->methodName;

        $url = self::URL_VK_API . $methodName . "?" . $this->buildRequestParams($opt);
        
        $request = file_get_contents($url);
        
        $request = json_decode($request);
        
        return new Response($request);

    }

    public function devMethod(){

		$answer = $this->sending("groups.getById", ["fields"=>"members_count"]);
		$members_count = $answer->data[0]->members_count;
       
		$members_groups = 0;	
        $sd = 0;
        $mongo = new \App\Mongo("mongodb://localhost:27017");
		while($members_count > $members_groups){
            
			$answer = $this->getMembers25k($this->params['group_id'], $members_count);
            
			if($answer->data){

				$this->membersGroups = array_merge($this->membersGroups, $answer->data);

                $mongo->insertMany($answer->data);

				$members_groups = count($this->membersGroups);
			}
			else{
                break;
			}
		}
	}

	public function getMembers25k($group_id, $members_count) {
		$members_groups = count($this->membersGroups);
		$offset = 1000;
		$code =  '
            var members = [];
		    var offset = '.$offset.';

			while (offset < 25000 && ('.$members_groups.') < '.$members_count.')
			{
                members = members +  API.groups.getMembers(
                {
                    "group_id": '.$group_id.', 
                    "v": '.$this->connectVK->getVersion().', 
                    "sort": "id_asc", 
                    "fields": "bdate,first_name", 
                    "count": '.$offset.', 
                    "offset": ('.$members_groups.' + offset)
                }).items;
                offset = offset + '.$offset.';
            };
			return members;';
		$answer = $this->sending("execute", ["code" => $code]);
        return $answer;
	}




}