<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Header: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");

include "ProductDTO.php";
include("./connection.php");

$method = $_SERVER['REQUEST_METHOD'];
$conn = getConnection();
switch ($method) {
    case 'GET':
        $action = "searchByName";
        if (isset($_GET["action"])) {
            $action = $_GET["action"];
        }

        if ($action == "searchByName") {
            // Tìm sản phẩm theo tên
            $searchTerm = isset($_GET["name"]) ? $_GET["name"] : null;
            if (!$searchTerm) {
                echo json_encode(["message" => "Search term 'name' is required"]);
                http_response_code(400);
                exit();
            }

            $sql = "SELECT * FROM product WHERE name LIKE :searchTerm";
            $stmt = $conn->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "ProductDTO");
            $searchTerm = "%$searchTerm%"; // Add wildcards to search term
            $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();

            $products = [];
            while ($row = $stmt->fetch()) {
                $products[] = $row;
            }

            echo json_encode($products);
        }

        break;
    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(["message" => "Method not allowed"]);
        break;
}
?>
