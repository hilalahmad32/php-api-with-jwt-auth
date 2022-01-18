<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Method:POST');
header('Content-Type:application/json', 'Charset=UTF-8'); // write this one in every header
include '../database/Database.php';

$obj = new Database();

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id;
    $obj->delete("products", "id='{$id}'");
    $result = $obj->getResult();
    if ($result[0] == 1) {
        echo json_encode([
            'status' => 1,
            'message' => "Product Delete Successfully",
        ]);
    } else {
        echo json_encode([
            'status' => 0,
            'message' => "Server Problem",
        ]);
    }
} else {
    echo json_encode([
        'status' => 0,
        'message' => "Access Denied",
    ]);
}
