<?php

class ProductRepository{

    public static function addProduct($name, $content, $price, $img){
        $db= Connection::connect();
        if($_SESSION['user']->getRol() == 1){
            $q = 'INSERT INTO product (name, content, price, img) VALUES ("'.$content.'", '.$price.', "'.$img.'", 1)';
            if($db->query($q)){
                return $db->insert_id;
            }else{ 
                return false;
            }
        }
    }
    public static function deleteProduct($idProduct){
        $db= Connection::connect();
        if($_SESSION['user']->getRol() == 1){
            $q = 'UPDATE product SET l = 0 WHERE id = "'.$idUser.'"';
                return $db->query($q);
            }
            return false;
    }

    public static function getProducts(){
        $db = Connection::connect();
        $q = 'SELECT * FROM product WHERE visible = 1';
        $result = $db->query($q);
        $products = array();
        while ($row = $result->fetch_assoc()) {
            $products[] = new Product($row['id'], $row['name'], $row['content'], $row['price'], $row['img'], $row['visible']);
        }
        return $products;
    }

    public static function getProductById($idProduct){
        $db= Connection::connect();
        $q = 'SELECT * FROM product WHERE id = "'.$idProduct.'" AND visible = 1';
        $result = $db->query($q);
        if ($row = $result->fetch_assoc()) {
            return new Product($row['id'], $row['name'], $row['content'], $row['price'], $row['img'], $row['visible']);
        }
        return false;
    }

    public static function editProduct($idProduct,$price, $img){
        $db= Connection::connect();
        if($_SESSION['user']->getRol() == 1){
            $q = 'UPDATE product SET price = '.$price.', img = "'.$img.'" WHERE id = "'.$idProduct.'"';
            return $db->query($q);
        }
        return false;
    }
    
}
?>