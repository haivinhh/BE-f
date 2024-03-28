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
            if (isset($requestData['id_user'])) {
                $cartid = $requestData['id_cart'];

                if ($cartid == -1) {
                    $sql = "INSERT INTO cart (id_user, status,order_date) VALUES (:id_user,'N', NOW())";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id_user', $requestData['id_user'], PDO::PARAM_INT);
                    //$stmt->bindParam(':status', $requestData['status'], PDO::PARAM_STR);
                    $rs = $stmt->execute();
                    if ($rs) {
                        $cart_id = $conn->lastInsertId();
                        $sql = "INSERT INTO detailcart (id_cart, id_product, soluong) VALUES (:id_cart, :id_product, :soluong)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':id_cart', $cart_id, PDO::PARAM_INT);
                        $stmt->bindParam(':id_product', $requestData['id_product'], PDO::PARAM_INT);
                        $stmt->bindParam(':soluong', $requestData['soluong'], PDO::PARAM_INT);
                        // $stmt->bindParam(':tong_tien', $requestData['tong_tien'], PDO::PARAM_STR);
                        $rss = $stmt->execute();
                        updateCartTotal($conn, $cart_id);
                        updateDetailCartTotal($conn, $cart_id);
                        echo json_encode(["message" => $cart_id]);
                    } else {
                        echo json_encode(["message" => "failed to insert into cart"]);
                    }
                    
                } else {
                    $sql = "INSERT INTO detailcart (id_cart, id_product, soluong) VALUES (:id_cart, :id_product, :soluong)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id_cart', $cartid, PDO::PARAM_INT);
                    $stmt->bindParam(':id_product', $requestData['id_product'], PDO::PARAM_INT);
                    $stmt->bindParam(':soluong', $requestData['soluong'], PDO::PARAM_INT);
                    //$stmt->bindParam(':tong_tien', $requestData['tong_tien'], PDO::PARAM_STR);

                    $rss = $stmt->execute();
                    updateCartTotal($conn, $cartid);
                    updateDetailCartTotal($conn, $cartid); // Corrected variable name
                    echo json_encode(["message" => $cartid]);
                }
            } else {
                echo json_encode(["message" => "id_user and status are required"]);
            }
        } catch (Exception $e) {
            echo json_encode(["message" => $e->getMessage()]);
        }
        break;

    case 'GET':
        try {
            $action = isset($_GET['action']) ? $_GET['action'] : null;
            $id = isset($_GET['id']) ? $_GET['id'] : null;

            if ($action === 'detailCart') {
                if ($id) {
                    // Find detailcart by user ID
                    $sqlDetail = "SELECT dc.id_dc, dc.id_cart, dc.id_product, dc.soluong, dc.tong_tien,
                                              p.name AS product_name, p.price AS product_price ,p.image
                                          FROM detailcart dc
                                          JOIN product p ON dc.id_product = p.id
                                          JOIN cart c ON dc.id_cart = c.id_cart
                                          WHERE c.id_user = :id_user and c.status = 'N'";
                    $stmtDetail = $conn->prepare($sqlDetail);
                    $stmtDetail->bindParam(':id_user', $id, PDO::PARAM_INT);
                    $stmtDetail->execute();
                    $detailCart = $stmtDetail->fetchAll(PDO::FETCH_ASSOC);

                    echo json_encode($detailCart);
                } else {
                    echo json_encode(["message" => "User ID is required"]);
                }
            } else if ($action === 'totalCart') {
                // Find total price for each cart
                $sqlTotalCart = "SELECT c.id_cart, c.id_user, c.status, c.order_date, 
                                              SUM(p.price * dc.soluong) AS total_price
                                          FROM cart c
                                          JOIN detailcart dc ON c.id_cart = dc.id_cart
                                          JOIN product p ON dc.id_product = p.id
                                          WHERE c.id_user = :id_user
                                          GROUP BY c.id_cart, c.id_user, c.status, c.order_date";
                $stmtTotalCart = $conn->prepare($sqlTotalCart);
                $stmtTotalCart->bindParam(':id_user', $id, PDO::PARAM_INT);
                $stmtTotalCart->execute();
                $totalCarts = $stmtTotalCart->fetchAll(PDO::FETCH_ASSOC);

                echo json_encode($totalCarts);
            } else if ($action === 'getTotalPrice') {
                if ($id) {
                    // Find total price of all carts for a specific user
                    $sqlTotalPrice = "SELECT SUM(tong_tien) AS total_price
                                          FROM cart
                                          WHERE id_user = :id_user";
                    $stmtTotalPrice = $conn->prepare($sqlTotalPrice);
                    $stmtTotalPrice->bindParam(':id_user', $id, PDO::PARAM_INT);
                    $stmtTotalPrice->execute();
                    $totalPrice = $stmtTotalPrice->fetch(PDO::FETCH_ASSOC);

                    echo json_encode($totalPrice);
                } else {
                    echo json_encode(["message" => "User ID is required"]);
                }
            } else if ($action === 'countDetailCart') {
                // Count number of detailcart for a specific user's id_cart
                if ($id) {
                    $sqlCountDetailCart = "SELECT COUNT(*) AS detail_cart_count
                                               FROM detailcart dc
                                               JOIN cart c ON dc.id_cart = c.id_cart
                                               WHERE c.id_user = :id_user
                                               GROUP BY c.id_cart";
                    $stmtCountDetailCart = $conn->prepare($sqlCountDetailCart);
                    $stmtCountDetailCart->bindParam(':id_user', $id, PDO::PARAM_INT);
                    $stmtCountDetailCart->execute();
                    $countDetailCart = $stmtCountDetailCart->fetch(PDO::FETCH_ASSOC);

                    echo json_encode($countDetailCart);
                } else {
                    echo json_encode(["message" => "User ID is required"]);
                }
            } else if ($action === 'getIdcartByIdUser') {
                if ($id) {
                    // Find cart by user ID
                    $sqlCartByIdUser = "SELECT c.id_cart FROM cart c WHERE c.id_user = :id_user and c.status ='N'";
                    $stmtCartByIdUser = $conn->prepare($sqlCartByIdUser);
                    $stmtCartByIdUser->bindParam(':id_user', $id, PDO::PARAM_INT);
                    $stmtCartByIdUser->execute();
                    $cartByIdUser = $stmtCartByIdUser->fetchAll(PDO::FETCH_ASSOC);

                    echo json_encode($cartByIdUser);
                } else {
                    echo json_encode(["message" => "User ID is required"]);
                }
            }else if ($action === 'bill') {
                if ($id) {
                    $sqlDetail = "SELECT dc.id_dc, dc.id_cart, dc.id_product, dc.soluong, dc.tong_tien,
                                          p.name AS product_name, p.price AS product_price, p.image,
                                          c.order_date
                                  FROM detailcart dc
                                  JOIN product p ON dc.id_product = p.id
                                  JOIN cart c ON dc.id_cart = c.id_cart
                                  WHERE c.id_user = :id_user AND c.status = 'Y'";
                    $stmtDetail = $conn->prepare($sqlDetail);
                    $stmtDetail->bindParam(':id_user', $id, PDO::PARAM_INT);
                    $stmtDetail->execute();
                    $detailCart = $stmtDetail->fetchAll(PDO::FETCH_ASSOC);
            
                    echo json_encode($detailCart);
                } else {
                    echo json_encode(["message" => "User ID is required"]);
                }
            }
            
            
            else if ($action === 'getCartByIdUser') {
                if ($id) {
                    // Find cart by user ID
                    $sqlCartByIdUser = "SELECT c.id_cart,c.status,c.order_date,c.tong_tien FROM cart c WHERE c.id_user = :id_user";
                    $stmtCartByIdUser = $conn->prepare($sqlCartByIdUser);
                    $stmtCartByIdUser->bindParam(':id_user', $id, PDO::PARAM_INT);
                    $stmtCartByIdUser->execute();
                    $cartByIdUser = $stmtCartByIdUser->fetchAll(PDO::FETCH_ASSOC);

                    echo json_encode($cartByIdUser);
                } else {
                    echo json_encode(["message" => "User ID is required"]);
                }
             } else {
                // Find all carts
                $sqlAllCarts = "SELECT * FROM cart";
                $stmtAllCarts = $conn->prepare($sqlAllCarts);
                $stmtAllCarts->execute();
                $carts = $stmtAllCarts->fetchAll(PDO::FETCH_ASSOC);

                $response = [
                    "carts" => $carts
                ];
                echo json_encode($response);
            }
        } catch (Exception $e) {
            echo json_encode(["message" => $e->getMessage()]);
        }
        break;



    case 'DELETE':
        $message = ["message" => "false"];
        try {
            if (isset($_REQUEST["id_dc"])) {
                $id_dc = $_REQUEST["id_dc"];

                // Get cart ID from detail cart ID
                $cartId = getCartIdByDetailCartId($conn, $id_dc);

                $sql = "DELETE FROM `detailcart` WHERE `detailcart`.`id_dc` = :id_dc";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id_dc', $id_dc, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    // Update cart total after deleting detail cart
                    updateCartTotal($conn, $cartId);
                    $message = ["message" => "true"];
                } else {
                    $message = ["message" => "false"];
                }

                echo json_encode($message);
            } else {
                echo json_encode(["message" => "id_dc parameter is missing"]);
            }
        } catch (Exception $e) {
            echo json_encode(["message" => $e->getMessage()]);
        }
        break;


    case 'PUT':
        try {
            $requestData = json_decode(file_get_contents('php://input'), true);
            if (isset($requestData['id_dc']) && isset($requestData['soluong'])) {
                $id_dc = $requestData['id_dc'];
                $soluong = $requestData['soluong'];
                $cartid = $requestData['id_cart'] ?? null; // Sử dụng null coalescing operator để xử lý trường hợp không có 'id_cart'

                $sqlUpdate = "UPDATE detailcart SET soluong = :soluong WHERE id_dc = :id_dc";
                $stmtUpdate = $conn->prepare($sqlUpdate);
                $stmtUpdate->bindParam(':soluong', $soluong, PDO::PARAM_INT);
                $stmtUpdate->bindParam(':id_dc', $id_dc, PDO::PARAM_INT);
                $stmtUpdate->execute();

                if ($stmtUpdate->rowCount() > 0) {
                    $cartId = getCartIdByDetailCartId($conn, $id_dc); // Fixed variable name
                    updateDetailCartTotal($conn, $cartId);
                    updateCartTotal($conn, $cartId);
                    echo json_encode(["message" => "Update quantity successful"]);
                } else {
                    echo json_encode(["message" => "Failed to update quantity"]);
                }
            } else {
                echo json_encode(["message" => "id_dc and soluong are required"]);
            }
        } catch (Exception $e) {
            echo json_encode(["message" => $e->getMessage()]);
        }
        break;
}



function updateCartTotal($conn, $cartid)
{
    $sqlTotal = "UPDATE cart c
                 SET c.tong_tien = (
                     SELECT SUM(dr.soluong * p.price) 
                     FROM detailcart dr
                     JOIN product p ON dr.id_product = p.id
                     WHERE dr.id_cart = :id_cart
                     GROUP BY dr.id_cart
                 )
                 WHERE c.id_cart = :id_cart ";

    try {
        $stmtTotal = $conn->prepare($sqlTotal);
        $stmtTotal->bindParam(':id_cart', $cartid, PDO::PARAM_INT);
        $stmtTotal->execute();
        $rowCount = $stmtTotal->rowCount();
        if ($rowCount > 0) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo "Error updating cart total: " . $e->getMessage();
    }
}
function getCartIdByDetailCartId($conn, $detailCartId)
{
    $sql = "SELECT id_cart FROM detailcart WHERE id_dc = :id_dc";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_dc', $detailCartId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['id_cart'];
}
function updateDetailCartTotal($conn, $cartid)
{
    $sqlTotal = "UPDATE detailcart dr
                 JOIN product p ON dr.id_product = p.id
                 SET dr.tong_tien = dr.soluong * p.price
                 WHERE dr.id_cart = :id_cart";

    try {
        $stmtTotal = $conn->prepare($sqlTotal);
        $stmtTotal->bindParam(':id_cart', $cartid, PDO::PARAM_INT);
        $stmtTotal->execute();
        $rowCount = $stmtTotal->rowCount();
        if ($rowCount > 0) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo "Error updating detailcart total: " . $e->getMessage();
    }
}
function createCart($conn, $requestData) {
    try {
        $sql = "INSERT INTO cart (id_user, status, order_date) VALUES (:id_user, 'N', NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_user', $requestData['id_user'], PDO::PARAM_INT);
        $rs = $stmt->execute();
        if ($rs) {
            return $conn->lastInsertId();
        } else {
            throw new Exception("Failed to create cart");
        }
    } catch (Exception $e) {
        throw new Exception("Failed to create cart: " . $e->getMessage());
    }
}

function addToDetailCart($conn, $cartId, $requestData) {
    try {
        $sql = "INSERT INTO detailcart (id_cart, id_product, soluong) VALUES (:id_cart, :id_product, :soluong)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_cart', $cartId, PDO::PARAM_INT);
        $stmt->bindParam(':id_product', $requestData['id_product'], PDO::PARAM_INT);
        $stmt->bindParam(':soluong', $requestData['soluong'], PDO::PARAM_INT);
        $rss = $stmt->execute();
        updateCartTotal($conn, $cartId);
        updateDetailCartTotal($conn, $cartId);
    } catch (Exception $e) {
        throw new Exception("Failed to add to detailcart: " . $e->getMessage());
    }
}