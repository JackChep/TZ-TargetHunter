<?php
$user_id = 'y.emelyanov2003';


$request_params = array(
    "group_id" => 166884737,
    "v" => "5.199",
    "sort" => "id_asc",
    "fields" => "sex,bdate",
    "access_token" => "vk1.a.KmoCEbqfpJlCYQsX6BWZ2CxzY-3zyYGQbE_aUpMriMelrjgpJVIEHlswb-Ye3IDCkD2BFvDVNd0ON2qhcCMG02j0BoqWUHDonUk4nDE9ahhha3wvyLuot458dkqqM6mnbFH1lAkrV4DmEVWifRkz4BrUMU4ykl8vSncuXy8EJEfLixIl_jh2f5o858qoT15M"
);
/*$request_params = array(
    'user_id' => $user_id,
    'fields' => 'bdate',
    'v' => '5.199',
    'access_token' => '1820c82b1820c82b1820c82bd61b3709d8118201820c82b7e216090594283c896abd4c9'
);*/
$get_params = http_build_query($request_params);
$result = json_decode(file_get_contents('https://api.vk.com/method/groups.getMembers?' . $get_params));
//echo ($result->response[0]->bdate);

$el = json_encode($result);
echo $el;
?>

<?php

//https://oauth.vk.com/authorize?client_id=51888627&group_ids=166884737&display=page&redirect_uri=http://example.com/callback&scope=messages&response_type=token&v=5.131

//получение токена
//https://oauth.vk.com/authorize?client_id=51888627&display=page&redirect_uri=http://vk.com&scope=friends&response_type=token&v=5.131&state=123456

//token
//https://api.vk.com/blank.html#access_token=vk1.a.KmoCEbqfpJlCYQsX6BWZ2CxzY-3zyYGQbE_aUpMriMelrjgpJVIEHlswb-Ye3IDCkD2BFvDVNd0ON2qhcCMG02j0BoqWUHDonUk4nDE9ahhha3wvyLuot458dkqqM6mnbFH1lAkrV4DmEVWifRkz4BrUMU4ykl8vSncuXy8EJEfLixIl_jh2f5o858qoT15M&expires_in=86400&user_id=165368970&state=123456
//vk1.a.KmoCEbqfpJlCYQsX6BWZ2CxzY-3zyYGQbE_aUpMriMelrjgpJVIEHlswb-Ye3IDCkD2BFvDVNd0ON2qhcCMG02j0BoqWUHDonUk4nDE9ahhha3wvyLuot458dkqqM6mnbFH1lAkrV4DmEVWifRkz4BrUMU4ykl8vSncuXy8EJEfLixIl_jh2f5o858qoT15M



?>
