<?php
class GamaModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function listar() {
        try {
            $sql = "EXEC SP_LISTAR_GAMA";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function obtener($id) {
        try {
            $sql = "EXEC SP_OBTENER_GAMA :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function insertar($data) {
        try {
            $sql = "EXEC SP_INSERTAR_GAMA 
                    :id, :nom, :des";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $data['Id_gama']);
            $stmt->bindParam(":nom", $data['Nombre_gama']);
            $stmt->bindParam(":des", $data['Descripcion_gama']);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function actualizar($data) {
        try {
            $sql = "EXEC SP_ACTUALIZAR_GAMA 
                    :id, :nom, :des";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $data['Id_gama']);
            $stmt->bindParam(":nom", $data['Nombre_gama']);
            $stmt->bindParam(":des", $data['Descripcion_gama']);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function eliminar($id) {
        try {
            $sql = "EXEC SP_ELIMINAR_GAMA :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
