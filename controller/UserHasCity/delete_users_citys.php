<?php
use models\UserHasCity;
use repositories\UserHasCityRepository;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/config/database.php';
include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/models/UserHasCity.php';
include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/repositories/UserHasCityRepository.php';



$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data["user_id"]) &&
    !empty($data["city_id"]))
{
    $database = new Database();
    $db = $database->getConnection();

    $users_city = new UserHasCity();
    $users_city->userId = $data["user_id"];
    $users_city->cityId = $data["city_id"];

    $users_cityRep = new UserHasCityRepository($users_city, $db);

    if ($users_cityRep->delete())
    {
        http_response_code(201);

        echo json_encode(array("message" => "Пользователь был удалён."));
    }
    else
    {
        http_response_code(503);

        echo json_encode(["message" => "Невозможно удалить пользователя."]);
    }
}
else
{
    http_response_code(400);

    echo json_encode(["message" => "Невозможно удалить пользователя. Данные неполные."]);
}