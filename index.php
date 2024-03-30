<?php
set_time_limit(0);

//71474323  - 250к
//166317286  - 300
//203077985  - 100к


$vkCommunityId = '203077985';
$token = "token";

$requestParams = http_build_query([
    'group_id' => $vkCommunityId,
    'v' => '5.131',
    'access_token' => $token,
]);

$qty_users = json_decode(file_get_contents("https://api.vk.com/method/groups.getMembers?$requestParams"), true);
$qty = $qty_users['response']['count'];

$requestBody = "
    var members = [];
    var offset = 0;
    var response;
    while ( offset <= 24000 ){
        response = API.groups.getMembers({
            group_id: $vkCommunityId,
            offset: offset,
            sort: 'id_asc',
            fields: 'bdate,first_name'
        });
        members = members + response.items;
        offset = members.length;
        if(offset == $qty){
            return members;
        }
    } ;
    return members;";

$requestParams = http_build_query([
    'code' => $requestBody,
    'v' => '5.131',
    'access_token' => $token,
]);

$count = 0;
$data['data'] = [];

while( $count != $qty ){

    $response = json_decode(file_get_contents("https://api.vk.com/method/execute?$requestParams"), true);

    array_push($data['data'], $response['response']);

    $count += count($response['response']);

    //$data['data'] = $response['response'];

}

//$data['data'] = $response['response'];
//$data['count'] = count($response['response']);
$data['quantity_users'] = $qty_users['response']['count'];

$el = json_encode($data);
?>

<script>console.log(<?=$el?>)</script>
