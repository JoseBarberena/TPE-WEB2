<?php

require_once "app/models/UserModel.php";
require_once "app/views/LoginView.php";

class LoginController
{

    private $model;
    private $view;

    function __construct()
    {
        $this->model = new UserModel();
        $this->view = new LoginView();
    }

    function logout()
    {
        session_start();
        session_destroy();
        $this->view->showLogin("You Logged out");
    }

    function login()
    {
        $this->view->showLogin();
    }

    function verifyLogin()
    {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Obtengo el usuario de la base de datos
            $user = $this->model->getUser($email);
            var_dump($user);


            // Si el usuario existe y las contraseñas coinciden
            if ($user && password_verify($password, $user->password)) {

                session_start();
                $_SESSION["email"] = $email;

                $this->view->showHome();
            } else {
                $this->view->showLogin("Acceso denegado, reingrese los datos");
            }
        } else {
            $this->view->showLogin("Complete todos los campos");
        }
    }
}
