<?php

class DetailCartDTO
{
    public $id_dc;
    public $id_cart;
    public $id_product;
    public $soluong;
    public $tongdh;
    public $id_user; // Thêm id_user

    public function fromJson($json)
    {
        $this->id_dc = $json['id_dc'];
        $this->id_cart = $json['id_cart'];
        $this->id_product = $json['id_product'];
        $this->soluong = $json['soluong'];
        $this->tongdh = $json['tongdh'];
        $this->id_user = $json['id_user']; 
    }

    public function toJson()
    {
        return json_encode([
            'id_dc' => $this->id_dc,
            'id_cart' => $this->id_cart,
            'id_product' => $this->id_product,
            'soluong' => $this->soluong,
            'tongdh' => $this->tongdh,
            'id_user' => $this->id_user 
        ]);
    }
}

?>
