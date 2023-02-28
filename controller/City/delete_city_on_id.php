<?php
use models\City;
use repositories\СityRepository;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/config/database.php';
include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/models/City.php';
include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/repositories/СityRepository.php';

$city = new City();

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data["id_to_delete"]))
{
    $database = new Database();
    $db = $database->getConnection();

    $userRep = new СityRepository($city, $db);

    if ($userRep->deleteOnId($data["id_to_delete"])) {

        http_response_code(201);

        echo json_encode(array("message" => "Город был удалён."));

    }
    else
    {
        http_response_code(503);

        echo json_encode(["message" => "Невозможно удалить город."]);
    }
}

else {

    http_response_code(400);

    echo json_encode(["message" => "Невозможно удалить город. Данные неполные."]);
}