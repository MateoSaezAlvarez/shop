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
        $db = Connection::connect();
        $q = 'INSERT INTO purchaseLine (quantity, idProduct, idPurchase) VALUES (1, "' . $idProduct . '", "' . $idPurchase . '")';
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
}

?>