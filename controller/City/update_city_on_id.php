<?php
use models\City;
use repositories\СityRepository;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/config/database.php';
include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/models/City.php';
include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/repositories/СityRepository.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data["id_to_update"]))
{
    if( !empty($data["cityName"]))
    {
        $database = new Database();
        $db = $database->getConnection();

        $city = new City();
        $city->cityName = $data["cityName"];

        $cityRep = new СityRepository($city, $db);

        if ($cityRep->updateOnId($data["id_to_update"])) {

            http_response_code(201);

            echo json_encode(array("message" => "Город был обновлён."));

        }
        else
        {
            http_response_code(503);

            echo json_encode(["message" => "Невозможно обновить город. Неполные данные для обновления"]);
        }
    }
}

else {

    http_response_code(400);

    echo json_encode(["message" => "Невозможно обновить город. Данные неполные."]);
}