<?php
class GamaModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function listar() {
        $stmt = $this->conn->prepare("EXEC SP_LISTAR_GAMAS");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($id) {
        $stmt = $this->conn->prepare("EXEC SP_OBTENER_GAMA @Id_gama = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertar($data) {
        $stmt = $this->conn->prepare("
            EXEC SP_INSERTAR_GAMA 
                @Nombre_gama = :nombre_gama,
                @Descripcion_gama = :descripcion_gama
        ");
        
        return $stmt->execute([
            ':nombre_gama' => $data['nombre_gama'],
            ':descripcion_gama' => $data['descripcion_gama']
        ]);
    }

    public function actualizar($data) {
        $stmt = $this->conn->prepare("
            EXEC SP_ACTUALIZAR_GAMA 
                @Id_gama = :id_gama,
                @Nombre_gama = :nombre_gama,
                @Descripcion_gama = :descripcion_gama
        ");
        
        return $stmt->execute([
            ':id_gama' => $data['id_gama'],
            ':nombre_gama' => $data['nombre_gama'],
            ':descripcion_gama' => $data['descripcion_gama']
        ]);
    }
}
?>