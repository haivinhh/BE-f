<?php
class UserDTO {
    public $id_user; // Đổi tên từ 'id' thành 'id_user'
    public $username;
    public $password;
    public $role_id;
    public $phone; // Thêm trường phone kiểu int
    public $address; // Thêm trường address kiểu varchar
    public $full_name; // Thêm trường full_name kiểu varchar

    public function fromJson($json) {
        $this->id_user = isset($json['id_user']) ? (int)$json['id_user'] : null; // Sửa tên từ 'id' thành 'id_user'
        $this->username = $json['username'];
        $this->password = $json['password'];
        $this->role_id = isset($json['role_id']) ? (int)$json['role_id'] : null;
        $this->phone = isset($json['phone']) ? (int)$json['phone'] : null; // Xử lý trường phone kiểu int
        $this->address = isset($json['address']) ? $json['address'] : null; // Xử lý trường address kiểu varchar
        $this->full_name = isset($json['full_name']) ? $json['full_name'] : null; // Xử lý trường full_name kiểu varchar
    }

    public function toJson() {
        return json_encode([
            "id_user" => $this->id_user, // Sửa tên từ 'id' thành 'id_user'
            "username" => $this->username,
            "password" => $this->password,
            "role_id" => $this->role_id,
            "phone" => $this->phone, // Thêm trường phone kiểu int
            "address" => $this->address, // Thêm trường address kiểu varchar
            "full_name" => $this->full_name, // Thêm trường full_name kiểu varchar
        ]);
    }
}
?>
