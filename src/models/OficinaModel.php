<?php
class OficinaModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function listar() {
        try {
            $sql = "SELECT * FROM OFICINA";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }


    public function obtener($id) {
        try {
            $sql = "EXEC SP_OBTENER_OFICINA :id";
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
            $sql = "EXEC SP_INSERTAR_OFICINA 
                    :id, :dir, :tel, :ciu, :pro, :cp";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $data['Id_oficina']);
            $stmt->bindParam(":dir", $data['Direccion']);
            $stmt->bindParam(":tel", $data['Telefono']);
            $stmt->bindParam(":ciu", $data['Ciudad']);
            $stmt->bindParam(":pro", $data['Provincia']);
            $stmt->bindParam(":cp", $data['Codigo_postal']);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }


    /* =========================================
       ACTUALIZAR OFICINA
    ========================================== */
    public function actualizar($data) {
        try {
            $sql = "EXEC SP_ACTUALIZAR_OFICINA 
                :id, :dir, :ciu, :tel, :pro, :cp";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":id",    $data['Id_oficina']);
            $stmt->bindParam(":dir",   $data['Direccion']);
            $stmt->bindParam(":ciu",   $data['Ciudad']);
            $stmt->bindParam(":tel",   $data['Telefono']);
            $stmt->bindParam(":pro",   $data['Provincia']);
            $stmt->bindParam(":cp",   $data['Codigo_postal']);
            return $stmt->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    /* =========================================
       ELIMINAR CLIENTE
    ========================================== */
    public function eliminar($id) {
        try {
            $sql = "EXEC SP_ELIMINAR_CLIENTE :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            return $stmt->execute();

        } catch (PDOException $e) {
            return false;
        }
    }
}
