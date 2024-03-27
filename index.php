<?php

$vkCommunityId = '166884737';
$token = "YOUR_ACCESS_TOKEN";

$requestBody = "
var members = [];
var offset = 0;
var count = 1000;
var response;
do {
    response = API.groups.getMembers({
        group_id: $vkCommunityId,
        offset: offset,
        count: count,
        fields: 'bdate, country, city'
    });
    members = members + response.items;
    offset = members.length;
} while (offset < response.count);
return members;";

$requestParams = http_build_query([
    'code' => $requestBody,
    'v' => '5.131',
    'access_token' => $token,
]);

$response = json_decode(file_get_contents("https://api.vk.com/method/execute?$requestParams"), true);


?>
