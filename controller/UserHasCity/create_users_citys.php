<?php
use models\UserHasCity;
use repositories\UserHasCityRepository;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/config/database.php';
include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/models/UserHasCity.php';
include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/repositories/UserHasCityRepository.php';

$usersCity = new UserHasCity();

if (
    !empty($_POST['user_id']) &&
    !empty($_POST['city_id'])
)
{
    $usersCity->userId = $_POST['user_id'];
    $usersCity->cityId = $_POST['city_id'];

    $database = new Database();
    $db = $database->getConnection();

    $usersCityRep = new UserHasCityRepository($usersCity, $db);

    try {
        if ($usersCityRep->create()) {

            http_response_code(201);

            echo json_encode(array("message" => "Пользователь был создан."));

        }
        else
        {
            http_response_code(503);

            echo json_encode(["message" => "Невозможно создать пользователя."]);
        }
    }
    catch (PDOException $exception)
    {
        echo json_encode(["message" => "Невозможно создать cвязь, проверьте наличие таких записей в обеих таблицах."]);
    }
}

else {

    http_response_code(400);

    echo json_encode(["message" => "Невозможно создать пользователя. Данные неполные."]);
}