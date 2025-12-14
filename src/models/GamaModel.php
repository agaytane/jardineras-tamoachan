<?php
class GamaModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /* =========================
       LISTAR
    ========================== */
    public function listar() {
        $sql = "EXEC SP_LISTAR_GAMAS";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* =========================
       OBTENER
    ========================== */
    public function obtener($id) {
        $sql = "EXEC SP_OBTENER_GAMA :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* =========================
       INSERTAR
    ========================== */
    public function insertar($data) {
        $sql = "EXEC SP_INSERTAR_GAMA :nom, :des";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nom", $data['Nombre_gama']);
        $stmt->bindParam(":des", $data['Descripcion_gama']);

        return $stmt->execute();
    }

    /* =========================
       ACTUALIZAR
    ========================== */
    public function actualizar($data) {
        $sql = "EXEC SP_ACTUALIZAR_GAMA :id, :nom, :des";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $data['Id_gama'], PDO::PARAM_INT);
        $stmt->bindParam(":nom", $data['Nombre_gama']);
        $stmt->bindParam(":des", $data['Descripcion_gama']);

        return $stmt->execute();
    }

    /* =========================
       ELIMINAR
    ========================== */
    public function eliminar($id) {
        $sql = "EXEC SP_ELIMINAR_GAMA :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
