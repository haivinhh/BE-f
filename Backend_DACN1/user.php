<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");

include "UserDTO.php";
include("./connection.php");

$conn = getConnection();

// Hàm để xử lý request OPTIONS (Cross-Origin Resource Sharing - CORS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

$message = ["message" => "false"];

switch ($method) {
    case 'GET':
        $action = "findAllUser";
        if (isset($_GET["action"])) {
            $action = $_GET["action"];
        }
    
        if ($action == "findAllUser") {
            $sql = "SELECT * FROM users";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $users = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $user = new UserDTO();
                $user->fromJson($row);
                $users[] = $user;
            }
            echo json_encode($users);
        } else if ($action == "findById" && isset($_GET["id"])) {
            $id = $_GET["id"];
            $sql = "SELECT * FROM users WHERE id_user = :id"; // Đổi từ 'id' thành 'id_user'
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                $response = new UserDTO();
                $response->fromJson($user);
                echo json_encode($response);
            } else {
                echo json_encode(["message" => "User not found"]);
            }
        }
        break;    
    case 'POST':
        $message = ["message" => "All fields are required."];
        try {
            $requestData = json_decode(file_get_contents('php://input'), true);
            if (!empty($requestData['username']) && !empty($requestData['password']) && !empty($requestData['role_id']) && isset($requestData['phone']) && isset($requestData['address']) && isset($requestData['full_name'])) {
                $sql = "INSERT INTO users (username, password, role_id, phone, address, full_name) VALUES (:username, :password, :role_id, :phone, :address, :full_name)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':username', $requestData['username'], PDO::PARAM_STR);
                $stmt->bindParam(':password', $requestData['password'], PDO::PARAM_STR);
                $stmt->bindParam(':role_id', $requestData['role_id'], PDO::PARAM_INT);
                $stmt->bindParam(':phone', $requestData['phone'], PDO::PARAM_INT);
                $stmt->bindParam(':address', $requestData['address'], PDO::PARAM_STR);
                $stmt->bindParam(':full_name', $requestData['full_name'], PDO::PARAM_STR);

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
            if (!empty($data["id_user"])) {
                $id = $data["id_user"];
                $sql = "DELETE FROM users WHERE id_user = :id"; 
                $stmt = $conn->prepare($sql);
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
            
    case 'PUT':
        $message = ["message" => "false"];
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!empty($data['id_user']) && !empty($data['username']) && !empty($data['password']) && !empty($data['role_id']) && isset($data['phone']) && isset($data['address']) && isset($data['full_name'])) {
                $id = $data['id_user']; // Đổi từ 'id' thành 'id_user'
                $username = $data['username'];
                $password = $data['password'];
                $role_id = $data['role_id'];
                $phone = $data['phone'];
                $address = $data['address'];
                $full_name = $data['full_name'];

                $sql = "UPDATE users SET username = :username, password = :password, role_id = :role_id, phone = :phone, address = :address, full_name = :full_name WHERE id_user = :id"; 
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);
                $stmt->bindParam(':phone', $phone, PDO::PARAM_INT);
                $stmt->bindParam(':address', $address, PDO::PARAM_STR);
                $stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
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
?>
