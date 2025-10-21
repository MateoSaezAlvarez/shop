<?php

require_once('helpers/FileHelper.php');
require_once('models/User.php');
require_once('models/UserRepository.php');
require_once('models/Product.php');
require_once('models/ProductRepository.php');
require_once('models/Purchase.php');
require_once('models/PurchaseRepository.php');
require_once('models/PurchaseLine.php');
require_once('models/PurchaseLineRepository.php');

session_start();

if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = 0;
}

//cargar modelo

$db= Connection::connect();

if(isset($_GET['c'])){
    require_once('controllers/'.$_GET['c'].'Controller.php');
}else{
    require_once('controllers/productController.php');
}
//comprobar variables


//operar


// cargar vista

?>