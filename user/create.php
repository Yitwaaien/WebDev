<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");


include_once '../config/database.php';
include_once '../models/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);



if (
    !empty($_POST['city']) &&
    !empty($_POST['name']) &&
    !empty($_POST['username'])
) {


    $user->name = $_POST['name'];
    $user->city = $_POST['city'];
    $user->username = $_POST['username'];



    if ($user->create()) {

        http_response_code(201);
        echo json_encode(array("message" => "Пользователь был создан."));
    } else {
        http_response_code(503);

        echo json_encode(["message" => "Невозможно создать пользователя."]);
    }
} else {

    http_response_code(400);

    echo json_encode(["message" => "Невозможно создать пользователя. Данные неполные."]);
}
