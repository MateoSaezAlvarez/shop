<?php

class PurchaseRepository{
    public static function getPurchasesByUser($idUser){
        $db = Connection::connect();
        $q = 'SELECT *
            FROM purchase
            WHERE idUser = "'.$idUser.'" AND payStatus = 1 ORDER BY datetime DESC';
        $result = $db->query($q);
        $purchases = array();
        while ($row = $result->fetch_assoc()) {
            $purchases[] = new Purchase($row['id'], $row['datetime'], $row['payStatus'], $row['idUser']);
        }
        return $purchases;
    }

    public static function getPurchasebyId($idPurchase, $payStatus){
        $db = Connection::connect();
        $q = 'SELECT *
            FROM purchase
            WHERE id = "'.$idPurchase.'" AND payStatus = '.$payStatus;
        $result = $db->query($q);
        if ($row = $result->fetch_assoc()) {
            return new Purchase($row['id'], $row['datetime'], $row['payStatus'], $row['idUser']);
        }
        return false;
    }
    /*public static function getActivePurchase($idUser){
        return self::getPurchasebyId(self::getPurchasesByUser($idUser)[0]->getId(), 0);
    }
    */
    public static function getActivePurchase($idUser){
        $db = Connection::connect();
        $q = 'SELECT *
            FROM purchase
            WHERE idUser = "'.$idUser.'" AND payStatus = 0';
        $result = $db->query($q);
        if ($row = $result->fetch_assoc()) {
            return new Purchase($row['id'], $row['datetime'], $row['payStatus'], $row['idUser']);
        } else{
            $q = 'INSERT INTO purchase (datetime, payStatus, idUser) VALUES (null, 0, "'.$idUser.'")';
            $db->query($q);
            $q = 'SELECT *
            FROM purchase
            WHERE idUser = "'.$idUser.'" AND payStatus = 0';
            $result = $db->query($q);
            if ($row = $result->fetch_assoc()) {
                return new Purchase($row['id'], $row['datetime'], $row['payStatus'], $row['idUser']);
            }
        }
        return false;
    }

    public static function finishPurchase($idPurchase, $idUser){
        $db = Connection::connect();
        $purchaseLines = PurchaseLineRepository::getPurchaseLinesByPurchase($idPurchase);
        foreach ($purchaseLines as $purchaseLine) {
            ProductRepository::deleteStock($purchaseLine->getProduct()->getId(), $purchaseLine->getQuantity());
        }
        $q = 'UPDATE purchase SET payStatus = 1, datetime = NOW() WHERE id = "'.$idPurchase.'" AND idUser = "'.$idUser.'" AND payStatus = 0';
        return $db->query($q);
    }

    public static function getTotal($idPurchase, $idUser){
    $db = Connection::connect();
    $q = '
        SELECT SUM(pl.quantity * p.price) AS total
        FROM purchaseLine AS pl
        INNER JOIN product AS p ON pl.idProduct = p.id
        INNER JOIN purchase AS pu ON pl.idPurchase = pu.id
        WHERE pl.idPurchase = "'.$idPurchase.'" 
        AND pu.idUser = "'.$idUser.'"';
    $result = $db->query($q);
    if ($row = $result->fetch_assoc()) {
        return $row['total'] ?? 0;
    }
    return false;
}

}

?>