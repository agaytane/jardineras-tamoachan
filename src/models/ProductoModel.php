<?php
class ProductoModel {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function listar() {
        $stmt = $this->conn->prepare("EXEC SP_LISTAR_PRODUCTOS");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtener($id) {
        $stmt = $this->conn->prepare("EXEC SP_OBTENER_PRODUCTO :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function insertar($data) {
        $stmt = $this->conn->prepare(
            "EXEC SP_INSERTAR_PRODUCTO :nom, :des, :pre, :stock, :gama"
        );

        return $stmt->execute([
            ':nom'   => $data['nombre'],
            ':des'   => $data['descripcion'],
            ':pre'   => $data['precio_venta'],
            ':stock' => $data['stock'],
            ':gama'  => $data['fk_id_gama']
        ]);
    }
    public function actualizar($data) {
        $stmt = $this->conn->prepare(
            "EXEC SP_ACTUALIZAR_PRODUCTO 
             :id, :nom, :des, :pre, :stock, :gama"
        );

        return $stmt->execute([
            ':id'    => $data['id_producto'],
            ':nom'   => $data['nombre'],
            ':des'   => $data['descripcion'],
            ':pre'   => $data['precio_venta'],
            ':stock' => $data['stock'],
            ':gama'  => $data['fk_id_gama']
        ]);
    }


    public function eliminar($id) {
        $stmt = $this->conn->prepare("EXEC SP_ELIMINAR_PRODUCTO :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
