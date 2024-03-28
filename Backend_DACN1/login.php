<?php
require_once('connection.php');
require 'vendor/autoload.php'; // Để sử dụng thư viện Firebase JWT

use Firebase\JWT\JWT;

$key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZS'; // Thay thế bằng chuỗi bí mật của riêng bạn

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu gửi từ form
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->username) && isset($data->password)) {
        $username = $data->username;
        $password = $data->password;

        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "Fetched user: ";
  var_dump($user);

        if ($user) {
            if (password_verify($password, $user['password'])) { // Kiểm tra mật khẩu
                $role_id = $user['role_id'];
                $id_user = $user['id_user'];

                // Tạo JWT
                $issuedAt = time();
                $expireAt = $issuedAt + 3600; // 1 giờ
                $tokenId = base64_encode(random_bytes(32));
                $payload = array(
                    'iss' => 'http://192.168.19.101/Backend_DACN1/',
                    'iat' => $issuedAt,
                    'exp' => $expireAt,
                    'uid' => $id_user,
                    'role_id' => $role_id,
                );
                $token = JWT::encode($payload, $key, 'HS256');

                echo json_encode(array('success' => true, 'message' => 'Đăng nhập thành công', 'token' => $token));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Tên người dùng hoặc mật khẩu không đúng'));
            }
        } else {
            echo json_encode(array('success' => false, 'message' => 'Tên người dùng hoặc mật khẩu không đúng'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Thiếu thông tin'));
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('success' => false, 'message' => 'Method not allowed'));
}
?>
