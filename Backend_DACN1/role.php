<?php
include("./connection.php");
include("./UserDTO.php");
include("./RoleDTO.php"); // Thêm import cho RoleDTO
$conn = getConnection();

$method = $_SERVER['REQUEST_METHOD'];

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Header: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
session_start();

switch ($method) {
    case 'GET':
        $action = isset($_GET["action"]) ? $_GET["action"] : null;

        if ($action === "findAllRole") {
            $sql = "SELECT * FROM role";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $roles = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $role = new RoleDTO();
                $role->fromJson($row);
                $roles[] = $role;
            }

            echo json_encode($roles, JSON_UNESCAPED_UNICODE);
        } elseif ($action === "findAllUserByRole") {
            $sql = "SELECT * FROM users";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $users = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $user = new UserDTO();
                $user->fromJson($row);
                $users[] = $user;
            }

            echo json_encode($users, JSON_UNESCAPED_UNICODE);
        } elseif ($action === "findUsersByRoleId") {
            $role_Id = isset($_GET["role_Id"]) ? $_GET["role_Id"] : null;

            if ($role_Id !== null) {
                $sql = "SELECT * FROM users WHERE role_Id = :role_Id";
                $stmt = $conn->prepare($sql);
                $stmt->execute(array("role_Id" => $role_Id));
                $users = [];

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $user = new UserDTO();
                    $user->fromJson($row);
                    $users[] = $user;
                }

                echo json_encode($users, JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(array("error" => "Missing 'role_Id' parameter"), JSON_UNESCAPED_UNICODE);
            }
        } else {
            echo json_encode(array("error" => "Invalid action"), JSON_UNESCAPED_UNICODE);
        }
        break;
    default:
        echo json_encode(array("error" => "Invalid request method"), JSON_UNESCAPED_UNICODE);
}
?>
