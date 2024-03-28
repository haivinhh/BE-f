<?php

include("./connection.php");
include("./ProductDTO.php");
$conn = getConnection();

$method = $_SERVER['REQUEST_METHOD'];

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Header: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
session_start();
switch ($method) {
    case 'GET':
        // Kiểm tra xem có tham số 'action' được gửi hay không
        $action = isset($_GET["action"]) ? $_GET["action"] : "";

        if ($action == "findProductByCateId") {
            // Kiểm tra xem có tham số 'cateId' được gửi hay không
            $cateId = isset($_GET["cateId"]) ? $_GET["cateId"] : null;

            if ($cateId !== null) {
                $sql = "SELECT product.id, product.name, price, image ,content
                        FROM cate 
                        JOIN product ON product.cateId = cate.id 
                        WHERE cate.id = :cateId;";
                $stmt = $conn->prepare($sql);
                $stmt->execute(array("cateId" => $cateId));
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
            } else {
                // Trả về thông báo nếu thiếu tham số 'cateId'
                echo json_encode(array("error" => "Missing 'cateId' parameter"), JSON_UNESCAPED_UNICODE);
            }
        } else {
            // Trường hợp không có action, trả về tất cả danh mục (cate)
            $sql = "SELECT * FROM cate";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
        }
        break;
    case 'POST':
        $message = ["message" => "All fields are required."];
        try {
            $requestData = json_decode(file_get_contents('php://input'), true);
            if (!empty($requestData['name'])) {
                $sql = "INSERT INTO cate (name) VALUES (:name)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $requestData['name'], PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $message = ["message" => "success"];
                }
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
            $data = json_decode(file_get_contents("php://input"), true);
            if (!empty($data["id"])) {
                $id = $data["id"];

                // Kiểm tra xem danh mục có sản phẩm liên kết không
                $sql_check_products = "SELECT COUNT(*) AS total_products FROM product WHERE cateId = :id";
                $stmt_check_products = $conn->prepare($sql_check_products);
                $stmt_check_products->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt_check_products->execute();
                $total_products = $stmt_check_products->fetchColumn();

                if ($total_products > 0) {
                    // Nếu có sản phẩm liên kết, không được phép xóa
                    $message = ["message" => "Danh mục đang có sản phẩm liên kết, không thể xóa."];
                } else {
                    // Nếu không có sản phẩm liên kết, tiến hành xóa danh mục
                    $sql_delete_cate = "DELETE FROM cate WHERE id = :id";
                    $stmt_delete_cate = $conn->prepare($sql_delete_cate);
                    $stmt_delete_cate->bindParam(':id', $id, PDO::PARAM_INT);
                    if ($stmt_delete_cate->execute()) {
                        $message = ["message" => "true"];
                    }
                }
            }
            echo json_encode($message);
        } catch (Exception $e) {
            $message = ["message" => $e->getMessage()];
            echo json_encode($message);
            throw $e;
        }
        break;

    case 'PUT':
        $message = ["message" => "false"];
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!empty($data['id']) && !empty($data['name'])) {
                $id = $data['id'];
                $name = $data['name'];

                $sql = "UPDATE cate SET name = :name WHERE id = :id"; // Sửa đúng cú pháp SQL ở đây
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $message = ["message" => "true"];
                }
            }
            echo json_encode($message);
        } catch (Exception $e) {
            $message = ["message" => $e->getMessage()];
            echo json_encode($message);
            throw $e;
        }
        break;
}
