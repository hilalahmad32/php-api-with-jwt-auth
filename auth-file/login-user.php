<?php

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Method:POST');
header('Content-Type:application/json');
include '../database/Database.php';
include '../vendor/autoload.php';

use \Firebase\JWT\JWT;

$obj = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input", true));
    $email = htmlentities($data->email);
    $password = htmlentities($data->password);

    $obj->select('users', '*', null, "email='{$email}'", null, null);
    $datas = $obj->getResult();
    foreach ($datas as $data) {
        $id = $data['id'];
        $email = $data['email'];
        $name = $data['name'];
        // $password=$data['password'];
        if (!password_verify($password, $data['password'])) {
            echo json_encode([
                'status' => 0,
                'message' => 'Invalid Carditional',
            ]);
        } else {
            $payload = [
                'iss' => "localhost",
                'aud' => 'localhost',
                'exp' => time() + 1000, //10 mint
                'data' => [
                    'id' => $id,
                    'name' => $name,
                    'email' => $email,
                ],
            ];
            $secret_key = "Hilal ahmad khan";
            $jwt = JWT::encode($payload, $secret_key, 'HS256');
            echo json_encode([
                'status' => 1,
                'jwt' => $jwt,
                'message' => 'Login Successfully',
            ]);
        }
    }
} else {
    echo json_encode([
        'status' => 0,
        'message' => 'Access Denied',
    ]);
}
