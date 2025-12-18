<?php
require_once __DIR__ . '/../models/ClienteModel.php';
require_once __DIR__ . '/../helpers/auth.php';

class ClienteController {

    private ClienteModel $modelo;

    public function __construct($conn) {
        if (!isset($_SESSION['usuario'])) {
            header("Location: /LOGIN");
            exit;
        }

        $this->modelo = new ClienteModel($conn);
    }

    /* =========================
       INDEX 
    ========================== */
    public function index() {
        $ruta = "CLIENTES";
        $titulo = "Clientes";
        require __DIR__ . '/../views/cliente/index.php';
    }

    /* =========================
       LISTAR
    ========================== */
    public function listar() {
        $clientes = $this->modelo->listar();
        require __DIR__ . '/../views/cliente/listar.php';
    }

    /* =========================
       CREAR
    ========================== */
    public function crear() {
        requireRole(['ADMIN', 'GERENTE']);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require __DIR__ . '/../views/cliente/crear.php';
            return;
        }

        if (
            empty($_POST['Nombre_cte']) ||
            empty($_POST['Apellido_cte']) ||
            empty($_POST['Email_cte'])
        ) {
            $_SESSION['error'] = "❌ Datos obligatorios faltantes.";
            $_SESSION['detalle'] = "Verifique nombre, apellido y email.";
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=CREAR&entidad=Cliente&ruta=CLIENTES");
            exit;
        }

        $data = [
            'nombre_cte'    => trim($_POST['Nombre_cte']),
            'apellido_cte'  => trim($_POST['Apellido_cte']),
            'email_cte'     => trim($_POST['Email_cte']),
            'telefono_cte'  => trim($_POST['Telefono_cte'] ?? ''),
            'direccion_cte' => trim($_POST['Direccion_cte'] ?? '')
        ];

        try {
            $this->modelo->insertar($data);
            $_SESSION['exito'] = "✅ Cliente registrado correctamente.";
            header("Location: /VISTAS/RESULTADO?tipo=exito&accion=CREAR&entidad=Cliente&ruta=CLIENTES");
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Error al registrar cliente.";
            $_SESSION['detalle'] = $e->getMessage();
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=CREAR&entidad=Cliente&ruta=CLIENTES");
        }
        exit;
    }

    /* =========================
       EDITAR
    ========================== */
    public function editar($id = null) {
    requireRole(['ADMIN', 'GERENTE']);

    // 1️⃣ Si viene por POST (desde seleccionar_editar)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
    }

    // 2️⃣ Si NO hay ID → mostrar selector
    if (!$id) {
        $clientes = $this->modelo->listar();
        require __DIR__ . '/../views/cliente/seleccionar_editar.php';
        return;
    }

    // 3️⃣ Obtener cliente
    $cliente = $this->modelo->obtener($id);

    if (!$cliente) {
        $_SESSION['error'] = "❌ Cliente no encontrado.";
        header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Cliente&ruta=CLIENTES");
        exit;
    }

    // 5️⃣ Mostrar formulario de edición
    require __DIR__ . '/../views/cliente/editar.php';
}

    /* =========================
       ACTUALIZAR
    ========================== */
    public function actualizar() {
        requireRole(['ADMIN', 'GERENTE']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /CLIENTES");
            exit;
        }

        if (empty($_POST['Id_cliente'])) {
            $_SESSION['error'] = "❌ Datos inválidos.";
            $_SESSION['detalle'] = "Falta el identificador de cliente.";
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Cliente&ruta=CLIENTES");
            exit;
        }

        $data = [
            'id_cliente'    => (int) $_POST['Id_cliente'],
            'email_cte'     => trim($_POST['Email_cte']),
            'telefono_cte'  => trim($_POST['Telefono_cte'] ?? ''),
            'direccion_cte' => trim($_POST['Direccion_cte'] ?? '')
        ];

        try {
            $this->modelo->actualizar($data);
            $_SESSION['exito'] = "✅ Cliente actualizado.";
            header("Location: /VISTAS/RESULTADO?tipo=exito&accion=EDITAR&entidad=Cliente&ruta=CLIENTES");
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Error al actualizar cliente.";
            $_SESSION['detalle'] = $e->getMessage();
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=EDITAR&entidad=Cliente&ruta=CLIENTES");
        }
        exit;
    }

    /* =========================
       ELIMINAR
    ========================== */
    public function eliminar($id = null) {
        requireRole(['ADMIN']);

        // Permitir enviar ID por POST desde seleccionar_eliminar
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? $id;
        }

        if (!$id) {
            $clientes = $this->modelo->listar();
            require __DIR__ . '/../views/cliente/seleccionar_eliminar.php';
            return;
        }

        if (!$this->modelo->obtener($id)) {
            $_SESSION['error'] = "❌ Cliente no encontrado.";
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=ELIMINAR&entidad=Cliente&ruta=CLIENTES");
            exit;
        }

        try {
            $this->modelo->eliminar($id);
            $_SESSION['exito'] = "✅ Cliente eliminado.";
            header("Location: /VISTAS/RESULTADO?tipo=exito&accion=ELIMINAR&entidad=Cliente&ruta=CLIENTES");
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Error al eliminar cliente.";
            $_SESSION['detalle'] = $e->getMessage();
            header("Location: /VISTAS/RESULTADO?tipo=error&accion=ELIMINAR&entidad=Cliente&ruta=CLIENTES");
        }
        exit;
    }
}
