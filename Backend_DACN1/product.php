<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
include "ProductDTO.php";
include("./connection.php");

$id = "";
$sql = "";
$conn = getConnection();
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        $action = "findAll";
        if (isset($_GET["action"])) {
            $action = $_GET["action"];
        }

        if ($action == "findAll") {
            $sql = "SELECT * FROM product";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $products = [];
            while ($row = $stmt->fetch()) {
                $product = new ProductDTO();
                $product->fromJson($row);
                $products[] = $product;
            }
            echo json_encode($products);
        } else if ($action == "findById" && isset($_GET["id"])) {
            $id = $_GET["id"];
            $sql = "SELECT * FROM product WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($product) {
                $response = new ProductDTO();
                $response->fromJson($product);
                echo json_encode($response);
            } else {
                echo json_encode(["message" => "Product not found"]);
            }
        }
        break;
        case 'POST':
            $message = ["message" => "All fields are required."];
            try {
                $requestData = json_decode(file_get_contents('php://input'), true);
                if (!empty($requestData['name']) && !empty($requestData['price']) && !empty($requestData['content']) && !empty($requestData['image']) && !empty($requestData['cateId']) && isset($requestData['quantity'])) {
                    $sql = "INSERT INTO product (name, price, content, image, cateId, quantity) VALUES (:name, :price, :content, :image, :cateId, :quantity)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':name', $requestData['name'], PDO::PARAM_STR);
                    $stmt->bindParam(':price', $requestData['price'], PDO::PARAM_STR);
                    $stmt->bindParam(':content', $requestData['content'], PDO::PARAM_STR);
                    $stmt->bindParam(':image', $requestData['image'], PDO::PARAM_STR);
                    $stmt->bindParam(':cateId', $requestData['cateId'], PDO::PARAM_INT);
                    $stmt->bindParam(':quantity', $requestData['quantity'], PDO::PARAM_INT);
                    
                    if ($stmt->execute()) {
                        $message = ["message" => "success"];
                    } else {
                        $message = ["message" => "Failed to add product."];
                    }
                } else {
                    $message = ["message" => "All fields are required."];
                }
                echo json_encode($message);
            } catch (Exception $e) {
                $message = ["message" => $e->getMessage()];
                echo json_encode($message);
                throw $e;
            }
            break;
        
        
        
    case 'DELETE':
        $message = ["message" => "false"];
        try {
            $sql = "SELECT * FROM `product` WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $_REQUEST["id"], PDO::PARAM_INT);
            $stmt->execute();
            while ($stmt->fetch()) {
                $sql = "DELETE FROM `product` WHERE `product`.`id` = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $_REQUEST["id"], PDO::PARAM_INT);
                if ($stmt->execute()) {
                    $message = ["message" => "true"];
                }
            }
            echo json_encode($message);
        } catch (Exception $e) {
            echo $e;
            throw $e;
        }
        break;
    case 'PUT':
        $message = ["message" => "false"];
        try {
            $requestData = json_decode(file_get_contents('php://input'), true);
            if (!empty($requestData['id']) && !empty($requestData['name']) && !empty($requestData['price']) && !empty($requestData['content']) && !empty($requestData['image']) && !empty($requestData['cateId']) && isset($requestData['quantity'])) {
                $sql = "UPDATE product SET name = :name, price = :price, content = :content, image = :image, cateId = :cateId, quantity = :quantity WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $requestData['name'], PDO::PARAM_STR);
                $stmt->bindParam(':price', $requestData['price'], PDO::PARAM_STR);
                $stmt->bindParam(':content', $requestData['content'], PDO::PARAM_STR);
                $stmt->bindParam(':image', $requestData['image'], PDO::PARAM_STR);
                $stmt->bindParam(':cateId', $requestData['cateId'], PDO::PARAM_INT);
                $stmt->bindParam(':quantity', $requestData['quantity'], PDO::PARAM_INT);
                $stmt->bindParam(':id', $requestData['id'], PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $message = ["message" => "true"];
                }
            }
            echo json_encode($message);
        } catch (Exception $e) {
            echo $e;
            throw $e;
        }
        break;
}
?>
