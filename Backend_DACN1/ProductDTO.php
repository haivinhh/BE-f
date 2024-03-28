<?php
class ProductDTO {
    public $id;
    public $name;
    public $price;
    public $content;
    public $image;
    public $cateId;
    public $quantity;
   

    function fromJson($json) {
        $this->id = $json['id'];
        $this->name = $json['name'];
        $this->price = $json['price'];
        $this->content = $json['content'];
        $this->image = $json['image'];
        $this->cateId = $json['cateId'];
        $this->quantity = $json['quantity'];
        
    }
}
?>
