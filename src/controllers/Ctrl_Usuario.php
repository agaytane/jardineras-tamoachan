<?php
require_once __DIR__ . '/../models/UsuarioModel.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/error_helper.php';

class UsuarioController {
    private $modelo;

    public function __construct($conn) {
        if (!isset($_SESSION['usuario'])) {
            header("Location: /LOGIN");
            exit;
        }

        $this->modelo = new UsuarioModel($conn);
    }

    /* =========================
       INDEX
    ========================== */
    public function index() {
        $ruta = "USUARIOS";
        $titulo = "Usuarios";
        require __DIR__ . '/../views/usuario/index.php';
    }

    /* =========================
       LISTAR
    ========================== */
    public function listar() {
        requireRole(['ADMIN']);
        $usuarios = $this->modelo->listar();
        require __DIR__ . '/../views/usuario/listar.php';
    }

    /* =========================
       CREAR
    ========================== */
    public function crear() {
        requireRole(['ADMIN']);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $roles = $this->modelo->listarRoles();
            require __DIR__ . '/../views/usuario/crear.php';
            return;
        }

        if (empty($_POST['usuario']) || empty($_POST['password']) || empty($_POST['fk_id_rol'])) {
            $_SESSION['error'] = "❌ Datos inválidos.";
            $_SESSION['detalle'] = "Usuario, contraseña y rol son requeridos.";
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=CREAR&entidad=Usuario&ruta=USUARIOS");
            exit;
        }

        $data = [
            'usuario' => trim($_POST['usuario']),
            'password' => trim($_POST['password']),
            'fk_id_rol' => (int) $_POST['fk_id_rol']
        ];

        try {
            $this->modelo->insertar($data);
            $_SESSION['exito'] = "✅ Usuario creado correctamente.";
            header("Location: /VISTAS/RESULTADO?tipo=exito&accion=CREAR&entidad=Usuario&ruta=USUARIOS");
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();
            if (strpos($errorMsg, '50011') !== false || strpos($errorMsg, 'ya existe') !== false) {
                $_SESSION['error'] = "❌ El nombre de usuario ya existe.";
                $_SESSION['detalle'] = "Elija un nombre de usuario diferente.";
            } else {
                $_SESSION['error'] = "❌ Error al crear usuario.";
                $_SESSION['detalle'] = $e->getMessage();
            }
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=CREAR&entidad=Usuario&ruta=USUARIOS");
        }
        exit;
    }

    /* =========================
       EDITAR
    ========================== */
    public function editar($id = null) {
        requireRole(['ADMIN']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
        }

        if (!$id) {
            $usuarios = $this->modelo->listar();
            require __DIR__ . '/../views/usuario/seleccionar_editar.php';
            return;
        }

        $usuario = $this->modelo->obtener($id);

        if (!$usuario) {
            $_SESSION['error'] = "❌ Usuario no encontrado.";
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Usuario&ruta=USUARIOS");
            exit;
        }

        $roles = $this->modelo->listarRoles();
        require __DIR__ . '/../views/usuario/editar.php';
    }

    /* =========================
       ACTUALIZAR
    ========================== */
    public function actualizar() {
        requireRole(['ADMIN']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /USUARIOS");
            exit;
        }

        if (empty($_POST['id_usuario'])) {
            $_SESSION['error'] = "❌ Datos inválidos.";
            $_SESSION['detalle'] = "Falta el identificador de usuario.";
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Usuario&ruta=USUARIOS");
            exit;
        }

        $data = [
            'id_usuario' => (int) $_POST['id_usuario'],
            'fk_id_rol' => (int) $_POST['fk_id_rol'],
            'activo' => isset($_POST['activo']) ? 1 : 0
        ];

        try {
            $this->modelo->actualizar($data);
            $_SESSION['exito'] = "✅ Usuario actualizado.";
            header("Location: /VISTAS/RESULTADO?tipo=exito&accion=EDITAR&entidad=Usuario&ruta=USUARIOS");
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Error al actualizar usuario.";
            $_SESSION['detalle'] = $e->getMessage();
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Usuario&ruta=USUARIOS");
        }
        exit;
    }

    /* =========================
       CAMBIAR CONTRASEÑA
    ========================== */
    public function cambiarPassword($id = null) {
        requireRole(['ADMIN']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nueva_password'])) {
            $id = $_POST['id'] ?? null;
            $nuevaPassword = trim($_POST['nueva_password']);

            if (!$id || empty($nuevaPassword)) {
                $_SESSION['error'] = "❌ Datos inválidos.";
                header("Location: /VISTAS/RESULTADO?tipo=error&accion=cambiar contraseña&entidad=Usuario&ruta=USUARIOS");
                exit;
            }

            try {
                $this->modelo->cambiarPassword($id, $nuevaPassword);
                $_SESSION['exito'] = "✅ Contraseña actualizada.";
                header("Location: /VISTAS/RESULTADO?tipo=exito&accion=cambiar contraseña&entidad=Usuario&ruta=USUARIOS");
            } catch (Exception $e) {
                $_SESSION['error'] = "❌ Error al cambiar contraseña.";
                $_SESSION['detalle'] = $e->getMessage();
                header("Location: /VISTAS/RESULTADO?tipo=error&accion=cambiar contraseña&entidad=Usuario&ruta=USUARIOS");
            }
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
        }

        if (!$id) {
            $usuarios = $this->modelo->listar();
            require __DIR__ . '/../views/usuario/seleccionar_password.php';
            return;
        }

        $usuario = $this->modelo->obtener($id);
        if (!$usuario) {
            $_SESSION['error'] = "❌ Usuario no encontrado.";
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=cambiar contraseña&entidad=Usuario&ruta=USUARIOS");
            exit;
        }

        require __DIR__ . '/../views/usuario/cambiar_password.php';
    }

    /* =========================
       ELIMINAR
    ========================== */
    public function eliminar($id = null) {
        requireRole(['ADMIN']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
        }

        if (!$id) {
            $usuarios = $this->modelo->listar();
            require __DIR__ . '/../views/usuario/seleccionar_eliminar.php';
            return;
        }

        if (!$this->modelo->obtener($id)) {
            $_SESSION['error'] = "❌ Usuario no encontrado.";
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=ELIMINAR&entidad=Usuario&ruta=USUARIOS");
            exit;
        }

        try {
            $this->modelo->eliminar($id);
            $_SESSION['exito'] = "✅ Usuario eliminado.";
            header("Location: /VISTAS/RESULTADO?tipo=exito&accion=ELIMINAR&entidad=Usuario&ruta=USUARIOS");
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();
            if (strpos($errorMsg, '50012') !== false || strpos($errorMsg, 'último administrador') !== false) {
                $_SESSION['error'] = "❌ No se puede eliminar el último administrador activo.";
                $_SESSION['detalle'] = "Debe haber al menos un administrador en el sistema.";
            } else {
                $_SESSION['error'] = "❌ Error al eliminar usuario.";
                $_SESSION['detalle'] = $e->getMessage();
            }
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=ELIMINAR&entidad=Usuario&ruta=USUARIOS");
        }
        exit;
    }
}
