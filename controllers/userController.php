<?php

if (isset($_GET['logout'])) {
    $_SESSION['login']=0;
    $_SESSION['user']=0;
    header("Location: index.php");
}


    if(isset($_POST['login'])){
        if (!empty($_POST["user"]) && !empty($_POST["contra"])) {
            $_SESSION['error'] = UserRepository::loginUser($_POST["user"], $_POST["contra"]);
        }else{
            $_SESSION['error'] ="los campos estan vacios";
        }
    }

    /*
    if(isset($_GET['ver_users'])){
        if($_SESSION['user']->getRol() == 1){
            $users=UserRepository::getUsers();
            require_once('views/viewUsers.phtml');
            exit();
        }else{
            header("Location: index.php");
            exit();
        }
    }
    */
    if(isset($_GET['edit_user'])){
            require_once('views/editUser.phtml');
            exit();
    }

    if(isset($_POST['edit_img'])){
        if (isset($_FILES["img"]) ) {

            $nameImg = $_SESSION['user']->getId()."_".$_SESSION['user']->getUsername().".png";
            if(!FileHelper::fileHandler($_FILES["img"]["tmp_name"], "public/img/profile/".$nameImg)){
                $nameImg = "";
            }
            UserRepository::editImg($_SESSION['user']->getId(), $nameImg);
            $_SESSION['user']->setImg($nameImg);
            header("Location: index.php?c=product");
            exit;
        }
    }

    if(isset($_GET['remove_img'])){
            UserRepository::removeImg($_SESSION['user']->getId());
            $_SESSION['user']->setImg("default.png");
            header("Location: index.php?c=product");
            exit;
    }

    /*
    if(isset($_GET['add_admin'])){
        if($_SESSION['user']->getRol() == 1){
            UserRepository::addAdmin($_GET['add_admin']);
        }
        header("Location: index.php?c=user&ver_users=1");
        exit();
    }

    if(isset($_GET['delete_admin'])){
    if($_SESSION['user']->getRol() == 1){
        if($_SESSION['user']->getId() != $_GET['delete_admin']){
            UserRepository::deleteAdmin($_GET['delete_admin']);
        }else{
            $_SESSION['error'] = "No puedes quitarte el admin a ti mismo";
        }
        header("Location: index.php?c=user&ver_users=1");
        exit();
    }else{
        header("Location: index.php");
        exit();
    }   
    }
    */


    if(isset($_POST['signup'])){
        if (!empty($_POST["ruser"]) && !empty($_POST["rcontra"]) && !empty($_POST["rcontra2"])) {
            if(UserRepository::addUser($_POST["ruser"], $_POST["rcontra"], $_POST["rcontra2"])){
                header("Location: index.php");
            }else{
                require_once('views/signup.phtml');
                exit();
            }
        }else{
            $_SESSION['error'] ="los campos estan vacios";
            require_once('views/signup.phtml');
            exit();
        }
    }
if(isset($_GET['registro'])){
        require_once('views/signup.phtml');
        exit;
    }
if(isset($_GET['login'])){
    require_once('views/login.phtml');
    exit();
}
?>