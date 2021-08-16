<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

session_start();

include_once '../config/database.php';
include_once '../objects/phones.php';

$database = new Database();
$db = $database->getConnection();

$phones = new Phones($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->name) &&
    !empty($data->phone) &&
    !empty(session_id())
) {
    $phones->name = $data->name;
    $phones->phone = $data->phone;

    if ($phones->create())
    {
        http_response_code(201);
        echo json_encode(array("status" => "success", "message" => "Телефон добавлен"), JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(503);
        echo json_encode(array("status" => "error", "message" => "При добавлении телефона возникла ошибка"), JSON_UNESCAPED_UNICODE);
    }

} else {
    http_response_code(400);
    echo json_encode(array("status" => "error", "message" => "При обращении к api возникла ошибка"), JSON_UNESCAPED_UNICODE);
}