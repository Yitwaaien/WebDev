<?php

use models\User;
use repositories\UserRepository;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/config/database.php';
include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/models/User.php';
include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/repositories/UserRepository.php';

$database = new Database();
$db = $database->getConnection();

$user = new User();

$userRep = new UserRepository($user, $db);
$stmtOfUsersGet = $userRep->get();

$num = $stmtOfUsersGet->rowCount();

if ($num > 0) {

    $user_arr = array();
    $user_arr["users"] = array();


    while ($rowsOfUsers = $stmtOfUsersGet->fetch()) {
        // извлекаем строку
        extract($rowsOfUsers);
        $user_item = array(
            "user_id" => $user_id,
            "user_name" => $user_name,
            "user_username" => $user_username,
            "user's_citys" => array()
        );

        $stmtOfUsersCitysGet = $userRep->getUsersCitys($user_id);
        $rowsOfUsersCitys = $stmtOfUsersCitysGet->rowCount();

        if($rowsOfUsersCitys > 0)
        {
            while ($rowsOfUsersCitys = $stmtOfUsersCitysGet->fetch())
            {
                extract($rowsOfUsersCitys);

                array_push($user_item["user's_citys"], $city_name);
            }
        }
        $user_arr["users"][] = $user_item;
    }

    http_response_code(200);

    echo json_encode($user_arr);
}
else
{
    http_response_code(404);

    echo json_encode(["message" => "Пользователи не найдены."]);
}
