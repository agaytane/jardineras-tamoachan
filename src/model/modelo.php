<?php
class Empleado {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function obtenerTodos() {
        $sql = "SELECT * FROM EMPLEADO;";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

/* ==========================================================
   PRODUCTOS CRUD
   ========================================================== */
class ProductModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /* LISTAR TODOS */
    public function listar() {
        $sql = "EXEC SP_LISTAR_PRODUCTOS";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($id) {
        $sql = "EXEC SP_OBTENER_PRODUCTO :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertar($data) {
        $sql = "EXEC SP_INSERTAR_PRODUCTO 
                :id, :nom, :des, :precio, :stock, :gama";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $data['Id_producto']);
        $stmt->bindParam(":nom", $data['Nombre']);
        $stmt->bindParam(":des", $data['Descripcion']);
        $stmt->bindParam(":precio", $data['Precio_venta']);
        $stmt->bindParam(":stock", $data['Stock']);
        $stmt->bindParam(":gama", $data['Fk_id_gama']);

        return $stmt->execute();
    }

    public function actualizar($data) {
        $sql = "EXEC SP_ACTUALIZAR_PRODUCTO 
                :id, :nom, :des, :precio, :stock, :gama";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $data['Id_producto']);
        $stmt->bindParam(":nom", $data['Nombre']);
        $stmt->bindParam(":des", $data['Descripcion']);
        $stmt->bindParam(":precio", $data['Precio_venta']);
        $stmt->bindParam(":stock", $data['Stock']);
        $stmt->bindParam(":gama", $data['Fk_id_gama']);
        
        return $stmt->execute();
    }

    public function eliminar($id) {
        $sql = "EXEC SP_ELIMINAR_PRODUCTO :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}

/* ==========================================================
   DETALLES DE PEDIDOS
   ========================================================== */
class VistaPedidos {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function obtenerDetalles() {
        $sql = "SELECT * FROM Vista_Detalle_Pedidos;";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class VistasModel {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function pedidoClienteEmpleado() {
        $sql = "SELECT * FROM AGE_V_PEDIDO_CLIENTE_EMPLEADO;";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function productoGamaDetalle() {
        $sql = "SELECT * FROM AGE_V_PRODUCTO_GAMA_DETALLE;";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function detallePedidoInfo() {
        $sql = "SELECT * FROM AGE_V_DETALLE_PEDIDO_INFO;";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function empleadoOficinaPedidos() {
        $sql = "SELECT * FROM AGE_V_EMPLEADO_OFICINA_PEDIDOS;";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function clientePedidoProductos() {
        $sql = "SELECT * FROM AGE_V_CLIENTE_PEDIDO_PRODUCTOS;";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
