<?php

class PurchaseRepository{
    public static function getPurchasesByUser($idUser){
        $db = Connection::connect();
        $q = 'SELECT *
              FROM purchase
              WHERE idUser = "'.$idUser.'" AND payStatus = 1';
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
}

?>