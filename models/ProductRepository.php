<?php

class ProductRepository{

    public static function addProduct($name, $content, $price, $stock, $img){
        $db= Connection::connect();
        if($_SESSION['user']->getRol() == 1){
            $q = 'INSERT INTO product (name, content, price, img, visible) VALUES ("'.$name.'", "'.$content.'", '.$price.', '.$stock.', "'.$img.'", 1)';
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
            $products[] = new Product($row['id'], $row['name'], $row['content'], $row['price'], $row['stock'], $row['img'], $row['visible']);
        }
        return $products;
    }

    public static function getProductById($idProduct){
        $db= Connection::connect();
        $q = 'SELECT * FROM product WHERE id = "'.$idProduct.'" AND visible = 1';
        $result = $db->query($q);
        if ($row = $result->fetch_assoc()) {
            return new Product($row['id'], $row['name'], $row['content'], $row['price'], $row['stock'], $row['img'], $row['visible']);
        }
        return false;
    }

public static function editProduct($idProduct,$price, $stock, $img){
        $db= Connection::connect();
        if($_SESSION['user']->getRol() == 1){
            $q = 'UPDATE product SET price = '.$price.', stock = '.$stock.', img = "'.$img.'" WHERE id = "'.$idProduct.'"';
            return $db->query($q);
        }
        return false;
    }
    
}

public static function addStock($idProduct,$stock){
    $db= Connection::connect();
    if($_SESSION['user']->getRol() == 1){
        $q = 'UPDATE product SET stock = stock + '.$stock.' WHERE id = "'.$idProduct.'"';
        return $db->query($q);
    }
    return false;
}

public static function deleteStock($idProduct,$stock){
    $db= Connection::connect();
        $q = 'UPDATE product SET stock = stock - '.$stock.' WHERE id = "'.$idProduct.'"';
        return $db->query($q);
    return false;
}
?>