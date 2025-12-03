<?php
class VistasModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function pedidoClienteEmpleado() {
        return $this->listar("AGE_V_PEDIDO_CLIENTE_EMPLEADO");
    }

    public function productoGamaDetalle() {
        return $this->listar("AGE_V_PRODUCTO_GAMA_DETALLE");
    }

    public function detallePedidoInfo() {
        return $this->listar("AGE_V_DETALLE_PEDIDO_INFO");
    }

    public function empleadoOficinaPedidos() {
        return $this->listar("AGE_V_EMPLEADO_OFICINA_PEDIDOS");
    }

    public function clientePedidoProductos() {
        return $this->listar("AGE_V_CLIENTE_PEDIDO_PRODUCTOS");
    }

    // ✅ MÉTODO BASE PARA TODAS LAS VISTAS
    private function listar($vista) {
        try {
            $sql = "SELECT * FROM $vista";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
