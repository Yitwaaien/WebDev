<?php
use models\User;
use repositories\UserRepository;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/config/database.php';
include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/models/User.php';
include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/repositories/UserRepository.php';

$user = new User();

if (
    !empty($_POST['name']) &&
    !empty($_POST['username'])
    )
{
    $user->name = $_POST['name'];
    $user->username = $_POST['username'];

    $database = new Database();
    $db = $database->getConnection();

    $userRep = new UserRepository($user, $db);

    if ($userRep->create()) {

        http_response_code(201);

        echo json_encode(array("message" => "Пользователь был создан."));

    }
    else
    {
        http_response_code(503);

        echo json_encode(["message" => "Невозможно создать пользователя."]);
    }
}

else {

    http_response_code(400);

    echo json_encode(["message" => "Невозможно создать пользователя. Данные неполные."]);
}
