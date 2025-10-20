<?php

class Product{
    private $id;
    private $name;
    private $content;
    private $price;
    private $img;
    public function __construct($id,$name,$content,$price,$img){
        $this->id=$id;
        $this->name = $name;
        $this->content = $content;
        $this->price = $price;
        $this->img = $img;
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
    public function getImg(){
        return $this->img;
    }
    public function setImg($img){
        $this->img = $img;
    }
}

?>