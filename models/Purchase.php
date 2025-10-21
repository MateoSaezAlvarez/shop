<?php

class Purchase{
    private $id;
    private $datetime;
    private $payStatus;
    private $idUser;
    public function __construct($id,$datetime,$payStatus,$idUser){
        $this->id=$id;
        $this->datetime = $datetime;
        $this->payStatus = $payStatus;
        $this->idUser = $idUser;
    }
    public function getId(){
        return $this->id;
    }
    public function getDateTime(){
        return $this->datetime;
    }
    public function getpayStatus(){
        return $this->payStatus;
    }
    public function getIdUser(){
        return UserRepository::getUserById($this->idUser);
    }
    public function getPurchaseLines(){
        return PurchaseLineRepository::getPurchaseLinesByPurchase($this->id);
    }
}

?>