<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Method:POST');
header('Content-Type:application/json', 'Charset=UTF-8'); // write this one in every header
include '../database/Database.php';

$obj = new Database();

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id;
    $obj->select('products', "*", null, "id='{$id}'", null, null);
    $products = $obj->getResult();
    echo json_encode([
        'status' => 1,
        'message' => $products,
    ]);
} else {
    echo json_encode([
        'status' => 0,
        'message' => 'Access Denied',
    ]);
}
