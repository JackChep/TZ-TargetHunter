<?php

require('vendor/autoload.php');


$vkCommunityId = '50750585';
$token = "1820c82b1820c82b1820c82bd61b3709d8118201820c82b7e216090594283c896abd4c9";

// $vkCommunityId = readline('ID группы -> ');
// $token = readline('Токен -> ');


$vk = new \App\VK($token, '5.131');

$req = new \App\Request($vk, 'groups.getMembers', ['group_id' => 167742670]);

echo "<pre>";
$req = $req->Request();

$mongo = new \App\Mongo("mongodb://localhost:27017");
$mongo->insertMany($req->items);
//var_dump($req->items);
echo "всёёёёёёёё";

?>

<script>console.log(<?=json_encode($mongo)?>)</script>



