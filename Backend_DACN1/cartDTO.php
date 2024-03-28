<?php
class CartDTO
{
    public $id_cart;
    public $id_user;
    public $status;
    public $order_date;
    public $tong_tien;

    public function fromJson($json)
    {
        $this->id_cart = $json['id_cart'];
        $this->id_user = $json['id_user'];
        $this->status = $json['status'];
        $this->order_date = $json['order_date'];
        $this->tong_tien = $json['tong_tien'];
    }
}
?>
