<?php
// header("Access-Control-Allow-Origin: http://localhost:3000");
// header("Access-Control-Allow-Headers: http://localhost:3000");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
// include("connection.php");

// $conn = getConnection();
// $method = $_SERVER['REQUEST_METHOD'];

// switch ($method) {
//     case 'POST':
//         try {
//             $requestData = json_decode(file_get_contents('php://input'), true);
//             if (isset($requestData['id_cart']) && isset($requestData['id_product']) && isset($requestData['soluong']) && isset($requestData['tongdh'])) {
//                 $sql = "INSERT INTO detailcart (id_cart, id_product, soluong, tongdh) VALUES (:id_cart, :id_product, :soluong, :tongdh)";
//                 $stmt = $conn->prepare($sql);
//                 $stmt->bindParam(':id_cart', $requestData['id_cart'], PDO::PARAM_INT);
//                 $stmt->bindParam(':id_product', $requestData['id_product'], PDO::PARAM_INT);
//                 $stmt->bindParam(':soluong', $requestData['soluong'], PDO::PARAM_INT);
//                 $stmt->bindParam(':tongdh', $requestData['tongdh'], PDO::PARAM_INT);
//                 if ($stmt->execute()) {
//                     echo json_encode(["message" => "success"]);
//                 } else {
//                     echo json_encode(["message" => "failed to insert into detailcart"]);
//                 }
//             } else {
//                 echo json_encode(["message" => "id_cart, id_product, soluong, and tongdh are required"]);
//             }
//         } catch (Exception $e) {
//             echo json_encode(["message" => $e->getMessage()]);
//         }
//         break;

//     case 'GET':
//         try {
//             $id = isset($_GET['id']) ? $_GET['id'] : null;
//             if ($id) {
//                 $sql = "SELECT dc.*, p.name AS product_name, u.phone, u.address, u.full_name 
//                         FROM detailcart dc 
//                         JOIN product p ON dc.id_product = p.id_product 
//                         JOIN cart c ON dc.id_cart = c.id_cart 
//                         JOIN users u ON c.id_user = u.id_user 
//                         WHERE c.status = 'Thanh toán' AND c.id_user = :id_user";
//                 $stmt = $conn->prepare($sql);
//                 $stmt->bindParam(':id_user', $id, PDO::PARAM_INT);
//                 $stmt->execute();
//                 $detailCart = [];
//                 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//                     $detailCart[] = $row;
//                 }
//                 echo json_encode($detailCart);
//             } else {
//                 echo json_encode(["message" => "id_user is required"]);
//             }
//         } catch (Exception $e) {
//             echo json_encode(["message" => $e->getMessage()]);
//         }
//         break;

//     case 'PUT':
//         try {
//             $requestData = json_decode(file_get_contents('php://input'), true);
//             if (isset($requestData['id_detailcart']) && isset($requestData['soluong'])) {
//                 $id_detailcart = $requestData['id_detailcart'];
//                 $soluong = $requestData['soluong'];
//                 $sql = "UPDATE detailcart SET soluong = :soluong WHERE id_detailcart = :id_detailcart";
//                 $stmt = $conn->prepare($sql);
//                 $stmt->bindParam(':soluong', $soluong, PDO::PARAM_INT);
//                 $stmt->bindParam(':id_detailcart', $id_detailcart, PDO::PARAM_INT);
//                 if ($stmt->execute()) {
//                     echo json_encode(["message" => "success"]);
//                 } else {
//                     echo json_encode(["message" => "failed to update detailcart"]);
//                 }
//             } else {
//                 echo json_encode(["message" => "id_detailcart and soluong are required"]);
//             }
//         } catch (Exception $e) {
//             echo json_encode(["message" => $e->getMessage()]);
//         }
//         break;

//     case 'DELETE':
//         try {
//             $id = isset($_GET['id']) ? $_GET['id'] : null;
//             if ($id) {
//                 // Check if detailcart exists before deleting
//                 $checkDetailCart = "SELECT * FROM detailcart WHERE id_detailcart = :id_detailcart";
//                 $stmtCheckDetailCart = $conn->prepare($checkDetailCart);
//                 $stmtCheckDetailCart->bindParam(':id_detailcart', $id, PDO::PARAM_INT);
//                 $stmtCheckDetailCart->execute();
//                 $detailCartExists = $stmtCheckDetailCart->fetch(PDO::FETCH_ASSOC);

//                 if ($detailCartExists) {
//                     $deleteDetailCart = "DELETE FROM detailcart WHERE id_detailcart = :id_detailcart";
//                     $stmtDeleteDetailCart = $conn->prepare($deleteDetailCart);
//                     $stmtDeleteDetailCart->bindParam(':id_detailcart', $id, PDO::PARAM_INT);
//                     if ($stmtDeleteDetailCart->execute()) {
//                         echo json_encode(["message" => "success"]);
//                     } else {
//                         echo json_encode(["message" => "failed to delete detailcart"]);
//                     }
//                 } else {
//                     echo json_encode(["message" => "detailcart not found"]);
//                 }
//             } else {
//                 echo json_encode(["message" => "id_detailcart is required"]);
//             }
//         } catch (Exception $e) {
//             echo json_encode(["message" => $e->getMessage()]);
//         }
//         break;
// }

?>
