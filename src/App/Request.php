<?php

namespace App;

class Request
{


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
        ?>

        <script>
            console.log(<?=json_encode($requestParams)?>);
        </script>
        
        <?php
        
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

    public function Request($methodName = false, $opt = false){

        ?>

        <script>
            console.log("--------------request--------------");
        </script>
        
        <?php

        $methodName = !empty($methodName) ? $methodName : $this->methodName;

        $url = self::URL_VK_API . $methodName . "?" . $this->buildRequestParams($opt);
        
        //echo $request."<br>";
        
        $request = file_get_contents($url);
        
        $request = json_decode($request);


        ?>

        <script>
           
            console.log("<?=$url?>");
            console.log("<?=$methodName?>");
            console.log(<?=json_encode($request)?>);
            console.log("--------------request--------------");
            </script>
        
        <?php
        
        return new Response($request);

    }

    public function devMethod(){
		$opts = $this->buildRequestParams();

        // узнаем количество участников сообщества
		$answer = $this->Request("groups.getById", ["fields"=>"members_count"]);
		$members_count = $answer->data[0]->members_count;
        
        ?>

        <script>
            console.log(<?=json_encode($members_count)?>);
        </script>
        
        <?php
		$members_groups = 0;	
        $sd = 0;
        $mongo = new \App\Mongo("mongodb://localhost:27017");
		while($members_count > $members_groups){
			//usleep(300000);	//задержка на 0.3 сек.
			$answer = $this->getMembers25k($this->params['group_id'], $members_count);
            
			if($answer->data){

				$this->membersGroups = array_merge($this->membersGroups, $answer->data);

                $mongo->insertMany($answer->data);

				$members_groups = count($this->membersGroups);
			}
			else{
				echo "NO RESPONSE<br>";
                break;
				//die();
			}
            $sd++;
            echo "<br>-------------------------";
            echo "<br>Обработано: ".count($this->membersGroups)."<br>";
            echo "<br>-------------------------";
            
		}
        echo "<br>".count($this->membersGroups);
        echo "<br>запросов execute: ".$sd."<br>";
		//print_r($this->membersGroups);
		//die();
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
        //echo $offset."<br>";
		$answer = $this->Request("execute", ["code" => $code]);
        return $answer;
	}




}