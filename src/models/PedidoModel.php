<?php
class PedidoModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function listar() {
        try {
            $sql = "EXEC SP_LISTAR_PEDIDO";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function obtener($id) {
        try {
            $sql = "EXEC SP_OBTENER_PEDIDO :id";
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
            $sql = "EXEC SP_INSERTAR_PEDIDO 
                    :id, :fp, :fv, :fe, :est, :com, :cli, :emp";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $data['Id_pedido']);
            $stmt->bindParam(":fp", $data['Fecha_pedido']);
            $stmt->bindParam(":fv", $data['Fecha_prevista']);
            $stmt->bindParam(":fe", $data['Fecha_entrega']);
            $stmt->bindParam(":est", $data['Estado']);
            $stmt->bindParam(":com", $data['Comentarios']);
            $stmt->bindParam(":cli", $data['Fk_id_cliente'], PDO::PARAM_INT);
            $stmt->bindParam(":emp", $data['Fk_id_empleado'], PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function actualizar($data) {
        try {
            $sql = "EXEC SP_ACTUALIZAR_PEDIDO 
                    :id, :fp, :fv, :fe, :est, :com, :cli, :emp";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $data['Id_pedido']);
            $stmt->bindParam(":fp", $data['Fecha_pedido']);
            $stmt->bindParam(":fv", $data['Fecha_prevista']);
            $stmt->bindParam(":fe", $data['Fecha_entrega']);
            $stmt->bindParam(":est", $data['Estado']);
            $stmt->bindParam(":com", $data['Comentarios']);
            $stmt->bindParam(":cli", $data['Fk_id_cliente'], PDO::PARAM_INT);
            $stmt->bindParam(":emp", $data['Fk_id_empleado'], PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function eliminar($id) {
        try {
            $sql = "EXEC SP_ELIMINAR_PEDIDO :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
