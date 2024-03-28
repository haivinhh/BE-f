<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
include("connection.php");

$conn = getConnection();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        try {
            $requestData = json_decode(file_get_contents('php://input'), true);
            $cartId =  $requestData['id_cart'];
            $sqlUpdate = "UPDATE cart c SET c.status = 'Y' WHERE c.id_cart=:idcart";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':idcart', $cartId, PDO::PARAM_INT);
            $stmtUpdate->execute();

            if ($stmtUpdate->rowCount() > 0) {

                echo json_encode(["message" => "success"]);
            } else {
                echo json_encode(["message" => "fail"]);
            }
        } catch (Exception $e) { 
            echo json_encode(["message" =>  "fail"]);
        }
        break;
}
