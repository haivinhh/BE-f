<?php
require_once('connection.php');
require 'vendor/autoload.php'; // Để sử dụng thư viện Firebase JWT

use Firebase\JWT\JWT;

$key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZS'; // Thay thế bằng chuỗi bí mật của riêng bạn

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu gửi từ form
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->username) && isset($data->password) && isset($data->phone) && isset($data->address) && isset($data->full_name)) {
        $username = $data->username;
        $password = $data->password;
        $role_id = 3; // Đặt role_id cứng là 3 cho tài khoản user
        $phone = $data->phone;
        $address = $data->address;
        $full_name = $data->full_name;

        $conn = getConnection();
        $stmt = $conn->prepare("INSERT INTO users (username, password, role_id, phone, address, full_name) VALUES (:username, :password, :role_id, :phone, :address, :full_name)");
        $stmt->bindParam(':username', $username);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash password trước khi lưu trữ
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':full_name', $full_name);

        if ($stmt->execute()) {
            $user_id = $conn->lastInsertId(); // Lấy ID người dùng vừa tạo

            // Tạo JWT
            $issuedAt = time();
            $expireAt = $issuedAt + 3600; // 1 giờ
            $tokenId = base64_encode(random_bytes(32));
            $payload = array(
                'iss' => 'http://192.168.19.101/Backend_DACN1/',
                'iat' => $issuedAt,
                'exp' => $expireAt,
                'uid' => $user_id,
            );
            $token = JWT::encode($payload, $key, 'HS256');

            echo json_encode(array('success' => true, 'message' => 'Đăng ký thành công', 'token' => $token));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Đăng ký thất bại'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Thiếu thông tin'));
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('success' => false, 'message' => 'Method not allowed'));
}
?>
