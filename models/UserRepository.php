<?php

class UserRepository {

    public static function addUser($username, $password, $password2){
        $db= Connection::connect();
        if($password==$password2){
                $q = 'INSERT INTO user (username, password,img ,rol) VALUES ("'.$username.'", "'.md5($password).'","default.png", 0, 1)';
                return $db->query($q);
            }
            return false;
    }

    public static function deleteUser($idUser){
        $db= Connection::connect();
        $q = 'UPDATE user SET visible = 0 WHERE id = "'.$idUser.'"';
        return $db->query($q);
    }

    public static function editImg($idUser, $img){
        $db= Connection::connect();
        $q = 'UPDATE user SET img = "'.$img.'" WHERE id = "'.$idUser.'"';
        return $db->query($q);
    }
    public static function removeImg($idUser){
        $db= Connection::connect();
        $nameImg = $_SESSION['user']->getId()."_".$_SESSION['user']->getUsername().".png";
        unlink("./public/img/".$nameImg);
        $db= Connection::connect();
        $q = 'UPDATE user SET img = "default.png" WHERE id = "'.$idUser.'"';
        return $db->query($q);
    }
    /*public static function addAdmin($idUser){
        $db= Connection::connect();
        $q = 'UPDATE user SET rol = 1 WHERE id = "'.$idUser.'"';
        return $db->query($q);
    }
    public static function deleteAdmin($idUser){
        $db= Connection::connect();
        $q = 'UPDATE user SET rol = 0 WHERE id = "'.$idUser.'"';
        return $db->query($q);
    }
    */
    public static function getUsers(){
        $db = Connection::connect();
        $q = 'SELECT *
              FROM user';
        $result = $db->query($q);
        $users = array();
        while ($row = $result->fetch_assoc()) {
            $users[] = new User($row['id'], $row['username'], $row['img'], $row['rol'], $row['visible']);
        }
        return $users;
    }
    public static function getUserById($idUser){
        $db= Connection::connect();
        $q = 'SELECT * FROM user WHERE id = "'.$idUser.'"';
        $result = $db->query($q);
        if ($row = $result->fetch_assoc()) {
            return new User($row['id'], $row['username'], $row['img'], $row['rol'], $row['visible']);
        }
        return false;
    }
    public static function loginUser($username, $password){
        $db= Connection::connect();
        $error=0;
        $q = 'SELECT * FROM user WHERE username ="'.$username.'"';
            $result = $db->query($q);
            if($row = $result-> fetch_assoc()){
                if($row['password']==md5($password)){
                $_SESSION['user']= new User($row['id'],$row['username'], $row['img'], $row['rol']);
                header("Location: index.php");
                $_SESSION['login'] = 1;
                }else{
                    $error="contraseña incorrecta";
                }
        
            }else{
                $error="usuario incorrecto";
            }
        return $error;
    }
}

?>