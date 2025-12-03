<?php
class ProductoModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // ✅ LISTAR
    public function listar() {
        try {
            $sql = "SELECT p.*, g.Nombre_gama 
                    FROM PRODUCTO p
                    INNER JOIN GAMA_PRODUCTO g ON p.Fk_id_gama = g.Id_gama";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // ✅ OBTENER POR ID
    public function obtener($id) {
        try {
            $sql = "SELECT * FROM PRODUCTO WHERE Id_producto = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    // ✅ INSERTAR
    public function insertar($data) {
        try {
            $sql = "INSERT INTO PRODUCTO 
                (Id_producto, Nombre, Descripcion, Precio_venta, Stock, Fk_id_gama)
                VALUES 
                (:id, :nom, :des, :pre, :stock, :gama)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":id", $data['Id_producto']);
            $stmt->bindParam(":nom", $data['Nombre']);
            $stmt->bindParam(":des", $data['Descripcion']);
            $stmt->bindParam(":pre", $data['Precio_venta']);
            $stmt->bindParam(":stock", $data['Stock']);
            $stmt->bindParam(":gama", $data['Fk_id_gama']);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // ✅ ACTUALIZAR
    public function actualizar($data) {
        try {
            $sql = "UPDATE PRODUCTO SET 
                Nombre = :nom,
                Descripcion = :des,
                Precio_venta = :pre,
                Stock = :stock,
                Fk_id_gama = :gama
                WHERE Id_producto = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":id", $data['Id_producto']);
            $stmt->bindParam(":nom", $data['Nombre']);
            $stmt->bindParam(":des", $data['Descripcion']);
            $stmt->bindParam(":pre", $data['Precio_venta']);
            $stmt->bindParam(":stock", $data['Stock']);
            $stmt->bindParam(":gama", $data['Fk_id_gama']);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // ✅ ELIMINAR
    public function eliminar($id) {
        try {
            $sql = "DELETE FROM PRODUCTO WHERE Id_producto = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
