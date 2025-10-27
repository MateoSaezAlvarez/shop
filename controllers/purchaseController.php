<?php
if($_SESSION['login']){
    if(isset($_GET['add_purchase_line'])){
        $idProduct = $_GET['add_purchase_line'];
        $idPurchase = PurchaseRepository::getActivePurchase($_SESSION['user']->getId())->getId();
        PurchaseLineRepository::addPurchaseLine($idProduct, $idPurchase);
        if(isset($_GET['viewpurchase'])){
            header("Location: index.php?c=purchase&view_purchase=1");
            exit;
        }
        header("Location: index.php?c=product");
        exit;
    }
    if(isset($_GET['less_purchase_line'])){
        $idProduct = $_GET['less_purchase_line'];
        $idPurchase = PurchaseRepository::getActivePurchase($_SESSION['user']->getId())->getId();
        PurchaseLineRepository::lessPurchaseLine(PurchaseLineRepository::getPurchaseLine($idProduct,$idPurchase)->getId());
        header("Location: index.php?c=purchase&view_purchase=1");
        exit;
    }
    if(isset($_GET['delete_purchase_line'])){
        $idProduct = $_GET['delete_purchase_line'];
        $idPurchase = PurchaseRepository::getActivePurchase($_SESSION['user']->getId())->getId();
        PurchaseLineRepository::deletePurchaseLine(PurchaseLineRepository::getPurchaseLine($idProduct,$idPurchase)->getId());
        header("Location: index.php?c=purchase&view_purchase=1");
        exit;
    }
    if(isset($_GET['view_purchase'])){
        $purchase=PurchaseRepository::getActivePurchase($_SESSION['user']->getId());
        $carrito = PurchaseLineRepository::getProductsByPurchase($purchase->getId());
        require_once 'views/viewPurchaseActive.phtml';
        exit;
    }
    if(isset($_GET['view_purchase_history'])){
        $purchases = PurchaseRepository::getPurchasesByUser($_SESSION['user']->getId());
        require_once 'views/viewPurchaseHistory.phtml';
        exit;
    }
    if(isset($_GET['pay'])){
        $idPurchase = $_GET['pay'];
        PurchaseRepository::finishPurchase($idPurchase, $_SESSION['user']->getId());
        header("Location: index.php?c=product");
        exit;
    }

}
?>