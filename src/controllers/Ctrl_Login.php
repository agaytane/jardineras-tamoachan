<?php
require_once __DIR__ . '/../models/UsuarioModel.php';

class LoginController {

    private $model;

    public function __construct($conn) {
        $this->model = new UsuarioModel($conn);
    }

    public function index() {
        require __DIR__ . '/../views/login/login.php';
    }

    public function autenticar() {
        session_start();

        $usuario = trim($_POST['usuario']);
        $password = trim($_POST['password']);

        $user = $this->model->login($usuario, $password);

        if (!$user) {
            $_SESSION['error'] = "Usuario o contraseña incorrectos";
            header("Location: /LOGIN");
            exit();
        }

        // 🔥 Guardar sesión correctamente
        $_SESSION['usuario'] = $user['Usuario'];
        $_SESSION['rol']     = strtoupper($user['Nombre_rol']); // <- FORZAMOS SOLO POR SEGURIDAD

        header("Location: /INICIO");
        exit();
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: /LOGIN");
    }
}
