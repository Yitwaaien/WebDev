<?php

use models\City;
use repositories\СityRepository;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/config/database.php';
include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/models/City.php';
include_once '/home/zagor/Develop/tasks-from-Andrew/WebDev/repositories/СityRepository.php';

$database = new Database();
$db = $database->getConnection();

$city = new City();

$cityRep = new СityRepository($city, $db);
$stmt = $cityRep->get();

$num = $stmt->rowCount();

if ($num > 0) {
    $city_arr = array();
    $city_arr["city's"] = array();

    while ($rows = $stmt->fetch()) {
        // извлекаем строку
        extract($rows);

        $city_item = array(
            "city_id" => $city_id,
            "city_name" => $city_name,
        );

        $city_arr["city's"][] = $city_item;

    }

    http_response_code(200);

    echo json_encode($city_arr);
}
else
{
    http_response_code(404);

    echo json_encode(["message" => "Города не найдены."]);
}
