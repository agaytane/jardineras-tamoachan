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

class Producto {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function obtenerTdProductos() {
        $sql = "SELECT * FROM PRODUCTO;";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}