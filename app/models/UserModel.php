<?php

class UserModel
{

    private $db;

    function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=web2-2023;charset=utf8', 'root', '');
    }

    function getUser($email)
    {
        //Obtengo el usuario de la base de datos
        $sentencia = $this->db->prepare('SELECT * FROM usuarios WHERE email = ?');
        $sentencia->execute([$email]);
        $user = $sentencia->fetch(PDO::FETCH_OBJ);
        return $user;
    }
}
