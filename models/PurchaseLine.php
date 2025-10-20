<?php

class PurchaseLine{
    private $id;
    private $quantity;
    private $idProduct;
    private $idPurchase;
    public function __construct($id,$quantity,$idProduct,$idPurchase){
        $this->id=$id;
        $this->quantity = $quantity;
        $this->idProduct = $idProduct;
        $this->idPurchase = $idPurchase;
    }
    public function getId(){
        return $this->id;
    }
    public function getQuantity(){
        return $this->quantity;
    }
    public function getIdProduct(){
        return ProductRepository::getProductById($this->idProduct);
    }
    public function getIdPurchase(){
        return PurchaseRepository::getPurchaseById($this->idPurchase);
    }
}

?>