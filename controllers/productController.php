<?php

if ($_SESSION['login'] == 1) { 
    if(isset($_GET['add_product'])){
        require_once('views/addTheme.phtml');
        exit;
    }

    if (isset($_GET['delete_product'])) {
        ProductRepository::deleteProduct($_GET['delete_product']);
        header("Location: index.php?c=product");
        exit;
    }

    if(isset($_POST['create_product'])){
        if (!empty($_POST["name"]) && !empty($_POST["content"]) && !empty($_POST["price"]) && isset($_FILES["img"] )) {

            $nameImg = $_POST['name'].".png";
            if(!FileHelper::fileHandler($_FILES["img"]["tmp_name"], "public/img/products/".$nameImg)){
                $nameImg = "";
            }

            header("Location: index.php?c=product&id=".ProductRepository::addProduct($_POST["name"], $_POST["content"], $_POST["price"], $nameImg));
            exit;
        }
    }
}

    if(isset($_GET["id"])){
            $product=ProductRepository::getProductById($_GET["id"]);
            require_once 'views/viewProduct.phtml';
    }else{
        $products=ProductRepository::getProducts();
        require_once 'views/products.phtml';
        exit();
    }
}
?>