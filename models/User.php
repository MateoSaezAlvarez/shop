<?php

class User{
    private $id;
    private $username;
    private $img;
    private $rol;
    private $visible;
    public function __construct($id,$username,$img,$rol, $visible){
        $this->id=$id;
        $this->username = $username;
        $this->img = $img;
        $this->rol = $rol;
        $this->visible = $visible;
    }
    public function getId(){
        return $this->id;
    }
    public function getUsername(){
        return $this->username;
    }
    public function getImg(){
        return $this->img;
    }
    public function getRol(){
        return $this->rol;
    }
    public function getVisible(){
        return $this->visible;
    }
    public function setImg($img){
        $this->img = $img;
    }
}

?>