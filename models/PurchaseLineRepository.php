<?php
class PurchaseLineRepository{
    public static function getProductsByPurchase($idPurchase){
        $db = Connection::connect();
        $q = 'SELECT * FROM purchaseLine WHERE idPurchase = "' . $idPurchase . '"';
        $result = $db->query($q);
        $products = array();
        while ($row = $result->fetch_assoc()) {
            $purchaseLine = new PurchaseLine($row['id'], $row['quantity'], $row['idProduct'], $row['idPurchase']);
            $product = $purchaseLine->getIdProduct(); 
            if ($product !== null) {
                $products[] = $product;
            }
        }
        return $products;
    }

    public static function editPurchaseLine($idPurchaseLine, $quantity) {
        $db = Connection::connect();
        $q = 'UPDATE purchaseLine SET quantity = "' . $quantity . '" WHERE id = "' . $idPurchaseLine . '"';
        return $db->query($q);
    }

    public static function addPurchaseLine($idProduct, $idPurchase) {
    // Verificar si ya existe una línea con ese producto en esa compra
    $existingLine = self::getPurchaseLine($idProduct, $idPurchase);
    
    $db = Connection::connect();
    if ($existingLine) {
        // Si existe, incrementar la cantidad
        $q = 'UPDATE purchaseLine SET quantity = quantity + 1 WHERE idProduct = "' . $idProduct . '" AND idPurchase = "' . $idPurchase . '"';
    } else {
        // Si no existe, insertar nueva línea
        $q = 'INSERT INTO purchaseLine (quantity, idProduct, idPurchase) VALUES (1, "' . $idProduct . '", "' . $idPurchase . '")';
    }
    
    return $db->query($q);
}

    public static function getPurchaseLineById($idPurchaseLine, $idPurchase, $idProduct){
        $db = Connection::connect();
        $q = 'SELECT *
              FROM purchaseLine
              WHERE id = "'.$idPurchaseLine.'" AND idPurchase = "'.$idPurchase.'" AND idProduct = "'.$idProduct.'"';
        $result = $db->query($q);
        if ($row = $result->fetch_assoc()) {
            return new PurchaseLine($row['id'], $row['quantity'], $row['idProduct'], $row['idPurchase']);
        }
        return false;
    }

    public static function getProductByPurchaseLine($idPurchaseLine) {
        $db = Connection::connect();
        $q = 'SELECT * FROM purchaseLine WHERE id = "' . $idPurchaseLine . '"';
        $result = $db->query($q);
        if ($row = $result->fetch_assoc()) {
            return ProductRepository::getProductById($row['idProduct']);
        }
        return false;
    }

    public static function getPurchaseLine($idProduct, $idPurchase){
        $db = Connection::connect();
        $q = 'SELECT * FROM purchaseLine WHERE idProduct = "' . $idProduct . '" AND idPurchase = "' . $idPurchase . '"';
        $result = $db->query($q);
        if ($row = $result->fetch_assoc()) {
            return new PurchaseLine($row['id'], $row['quantity'], $row['idProduct'], $row['idPurchase']);
        }
        return false;
    }

    public static function deletePurchaseLine($idPurchaseLine) {
        $db = Connection::connect();
        $q = 'DELETE FROM purchaseLine WHERE id = "' . $idPurchaseLine . '"';
        return $db->query($q);
    }

    public static function lessPurchaseLine($idPurchaseLine) {
    // Primero, obtener la línea para saber su cantidad actual
    $db = Connection::connect();
    $q = 'SELECT quantity FROM purchaseLine WHERE id = "' . $idPurchaseLine . '"';
    $result = $db->query($q);
    
    if (!$result || $result->num_rows === 0) {
        return false; // No existe la línea
    }
    
    $row = $result->fetch_assoc();
    $currentQuantity = (int)$row['quantity'];
    
    if ($currentQuantity <= 1) {
        // Eliminar si es 1 o menos
        return self::deletePurchaseLine($idPurchaseLine);
    } else {
        // Restar 1
        $q = 'UPDATE purchaseLine SET quantity = quantity - 1 WHERE id = "' . $idPurchaseLine . '"';
        return $db->query($q);
    }
}
}

?>