<?php

if ($_SESSION['login'] == 1) { 
    if(isset($_GET['add_product'])){
        require_once('views/addProduct.phtml');
        exit;
    }

    if (isset($_GET['delete_product'])) {
        if (($_SESSION['user']) && ($_SESSION['user']->getRol()==1)) {
            ProductRepository::deleteProduct($_GET['delete_product']);
            header("Location: index.php?c=product");
            exit;
        }
    }

    if (isset($_GET['edit_product'])) {
        if (($_SESSION['user']) && ($_SESSION['user']->getRol()==1)) {
            $product = ProductRepository::getProductById($_GET['edit_product']);
            require_once 'views/editProduct.phtml';
            exit;
        }
    }

    if(isset($_POST['edit_producto'])){
        if(isset($_GET['idProduct'])){
            $product = ProductRepository::getProductById($_GET['idProduct']);
            if (!empty($_POST["price"]) && !empty($_POST["stock"]) ) {
                $nameImg = $product->getName() . ".png";

                if (isset($_FILES["img"]) && $_FILES["img"]["error"] === UPLOAD_ERR_OK) {
                    if (!FileHelper::fileHandler($_FILES["img"]["tmp_name"], "public/img/" . $nameImg)) {
                        $nameImg = "";
                    }
                } else {
                    $nameImg = $product->getImg();
                }
                ProductRepository::editProduct($product->getId(), $_POST["price"], $_POST["stock"], $nameImg);
                header("Location: index.php?id=".$_GET['idProduct']);
                exit;
            }
        }
    }

    if(isset($_POST['create_product'])){
        if (!empty($_POST["name"]) && !empty($_POST["content"]) && !empty($_POST["price"])  && !empty($_POST["stock"]) && isset($_FILES["img"] )) {

            $nameImg = $_POST['name'].".png";
            if(!FileHelper::fileHandler($_FILES["img"]["tmp_name"], "public/img/products/".$nameImg)){
                $nameImg = "";
            }

            header("Location: index.php?c=product&id=".ProductRepository::addProduct($_POST["name"], $_POST["content"], $_POST["price"], $_POST["stock"], $nameImg));
            exit;
        }
    }
}

    if(isset($_GET["id"])){
            $product=ProductRepository::getProductById($_GET["id"]);
            require_once 'views/viewProduct.phtml';
    }else{
        $products = ProductRepository::getProducts() ?? [];
        if (($_SESSION['user'])) {
            $carrito = PurchaseLineRepository::getProductsByPurchase(PurchaseRepository::getActivePurchase($_SESSION['user']->getId())->getId());
        }
        require_once 'views/products.phtml';
        exit();
    }
?>