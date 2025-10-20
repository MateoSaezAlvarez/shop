<?php

require_once('helpers/FileHelper.php');
require_once('models/User.php');
require_once('models/UserRepository.php');

session_start();

if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = 0;
}

//cargar modelo

$db= Connection::connect();

if(isset($_GET['c'])){
    require_once('controllers/'.$_GET['c'].'Controller.php');
}else{
    if(!($_SESSION['login'])){
        require_once('controllers/userController.php');
    }else{
        //require_once('controllers/themeController.php');
    }
}
//comprobar variables


//operar


// cargar vista

?>