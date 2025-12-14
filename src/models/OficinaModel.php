<?php
class OficinaModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /* =========================
       LISTAR
    ========================== */
    public function listar() {
        $sql = "EXEC SP_LISTAR_OFICINAS";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* =========================
       OBTENER
    ========================== */
    public function obtener($id) {
        $sql = "EXEC SP_OBTENER_OFICINA :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* =========================
       INSERTAR
    ========================== */
    public function insertar($data) {
        $sql = "EXEC SP_INSERTAR_OFICINA 
                :dir, :tel, :ciu, :pro, :cp";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":dir", $data['Direccion']);
        $stmt->bindParam(":tel", $data['Telefono']);
        $stmt->bindParam(":ciu", $data['Ciudad']);
        $stmt->bindParam(":pro", $data['Provincia']);
        $stmt->bindParam(":cp",  $data['Codigo_postal']);

        return $stmt->execute();
    }

    /* =========================
       ACTUALIZAR
    ========================== */
    public function actualizar($data) {
        $sql = "EXEC SP_ACTUALIZAR_OFICINA 
                :id, :dir, :tel, :ciu, :pro, :cp";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id",  $data['Id_oficina'], PDO::PARAM_INT);
        $stmt->bindParam(":dir", $data['Direccion']);
        $stmt->bindParam(":tel", $data['Telefono']);
        $stmt->bindParam(":ciu", $data['Ciudad']);
        $stmt->bindParam(":pro", $data['Provincia']);
        $stmt->bindParam(":cp",  $data['Codigo_postal']);

        return $stmt->execute();
    }

    /* =========================
       ELIMINAR
    ========================== */
    public function eliminar($id) {
        $sql = "EXEC SP_ELIMINAR_OFICINA :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
