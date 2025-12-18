<?php
class OficinaModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function listar() {
        $stmt = $this->conn->prepare("EXEC SP_LISTAR_OFICINAS");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($id) {
        $stmt = $this->conn->prepare("EXEC SP_OBTENER_OFICINA @Id_oficina = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertar($data) {
        $stmt = $this->conn->prepare("
            EXEC SP_INSERTAR_OFICINA 
                @Direccion = :direccion,
                @Telefono = :telefono,
                @Ciudad = :ciudad,
                @Provincia = :provincia,
                @Codigo_postal = :codigo_postal
        ");
        
        return $stmt->execute([
            ':direccion' => $data['direccion'],
            ':telefono' => $data['telefono'],
            ':ciudad' => $data['ciudad'],
            ':provincia' => $data['provincia'],
            ':codigo_postal' => $data['codigo_postal']
        ]);
    }

    public function actualizar($data) {
        $stmt = $this->conn->prepare("
            EXEC SP_ACTUALIZAR_OFICINA 
                @Id_oficina = :id_oficina,
                @Direccion = :direccion,
                @Telefono = :telefono,
                @Ciudad = :ciudad,
                @Provincia = :provincia,
                @Codigo_postal = :codigo_postal
        ");
        
        return $stmt->execute([
            ':id_oficina' => $data['id_oficina'],
            ':direccion' => $data['direccion'],
            ':telefono' => $data['telefono'],
            ':ciudad' => $data['ciudad'],
            ':provincia' => $data['provincia'],
            ':codigo_postal' => $data['codigo_postal']
        ]);
    }

    public function eliminar($id) {
        $stmt = $this->conn->prepare("EXEC SP_ELIMINAR_OFICINA @Id_oficina = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function contarEmpleadosAsociados($id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM EMPLEADO WHERE Fk_id_oficina = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }
}
?>