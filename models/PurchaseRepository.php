<?php

class PurchaseRepository{
    public static function getPurchasesByUser($idUser){
        $db = Connection::connect();
        $q = 'SELECT *
              FROM purchase
              WHERE idUser = "'.$idUser.'"';
        $result = $db->query($q);
        $purchases = array();
        while ($row = $result->fetch_assoc()) {
            $purchases[] = new Purchase($row['id'], $row['datetime'], $row['payStatus'], $row['idUser']);
        }
        return $purchases;
    }

    public static function getPurchasebyId($idPurchase){
        $db = Connection::connect();
        $q = 'SELECT *
              FROM purchase
              WHERE id = "'.$idPurchase.'"';
        $result = $db->query($q);
        if ($row = $result->fetch_assoc()) {
            return new Purchase($row['id'], $row['datetime'], $row['payStatus'], $row['idUser']);
        }
        return false;
    }
}

?>