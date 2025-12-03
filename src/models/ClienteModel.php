<?php
class ClienteModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function listar() {
        try {
            $sql = "EXEC SP_LISTAR_CLIENTE";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function obtener($id) {
        try {
            $sql = "EXEC SP_OBTENER_CLIENTE :id";
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
            $sql = "EXEC SP_INSERTAR_CLIENTE 
                    :id, :nom, :ape, :email, :tel, :dir";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $data['Id_cliente']);
            $stmt->bindParam(":nom", $data['Nombre_cte']);
            $stmt->bindParam(":ape", $data['Apellido_cte']);
            $stmt->bindParam(":email", $data['Email_cte']);
            $stmt->bindParam(":tel", $data['Telefono_cte']);
            $stmt->bindParam(":dir", $data['Direccion_cte']);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function actualizar($data) {
        try {
            $sql = "EXEC SP_ACTUALIZAR_CLIENTE 
                    :id, :nom, :ape, :email, :tel, :dir";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $data['Id_cliente']);
            $stmt->bindParam(":nom", $data['Nombre_cte']);
            $stmt->bindParam(":ape", $data['Apellido_cte']);
            $stmt->bindParam(":email", $data['Email_cte']);
            $stmt->bindParam(":tel", $data['Telefono_cte']);
            $stmt->bindParam(":dir", $data['Direccion_cte']);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

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
