<?php

class Product{
    private $id;
    private $name;
    private $content;
    private $price;
    private $stock;
    private $img;
    private $visible;
    public function __construct($id,$name,$content,$price,$stock,$img, $visible){
        $this->id=$id;
        $this->name = $name;
        $this->content = $content;
        $this->price = $price;
        $this->stock = $stock;
        $this->img = $img;
        $this->visible = $visible;
    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getContent(){
        return $this->content;
    }
    public function getPrice(){
        return $this->price;
    }
    public function getStock(){
        return $this->stock;
    }
    public function getImg(){
        return $this->img;
    }
    public function getVisible(){
        return $this->visible;
    }
    public function setImg($img){
        $this->img = $img;
    }
}

?>