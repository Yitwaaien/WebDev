<?php

use models\User;
use repositories\UserRepository;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/config/database.php';
include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/models/User.php';
include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/repositories/UserRepository.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data["id_to_update"]))
{
    if( !empty($data["name"]&&
        !empty($data["username"])))
    {
        $database = new Database();
        $db = $database->getConnection();

        $user = new User();
        $user->name = $data["name"];
        $user->username = $data["username"];

        $userRep = new UserRepository($user, $db);

        if ($userRep->updateOnId($data["id_to_update"])) {

            http_response_code(201);

            echo json_encode(array("message" => "Пользователь был обновлён."));

        }
        else
        {
            http_response_code(503);

            echo json_encode(["message" => "Невозможно обновить пользователя. Неполные данные для обновления"]);
        }
    }
}

else {

    http_response_code(400);

    echo json_encode(["message" => "Невозможно обновить пользователя. Данные неполные."]);
}