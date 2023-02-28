<?php
use models\City;
use repositories\СityRepository;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/config/database.php';
include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/models/City.php';
include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/repositories/СityRepository.php';

if (!empty($_POST['cityName']))
{
    $city = new City();
    $city->cityName = $_POST['cityName'];

    $database = new Database();
    $db = $database->getConnection();

    $cityRep = new СityRepository($city, $db);

    if ($cityRep->create())
    {
        http_response_code(201);

        echo json_encode(array("message" => "Город был создан."));
    }
    else
    {
        http_response_code(503);

        echo json_encode(["message" => "Невозможно создать город."]);
    }
}
else
{
    http_response_code(400);

    echo json_encode(["message" => "Невозможно создать город. Данные неполные."]);
}