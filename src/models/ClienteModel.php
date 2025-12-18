<?php
class ClienteModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function listar() {
        $stmt = $this->conn->prepare("EXEC SP_LISTAR_CLIENTES");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($id) {
        $stmt = $this->conn->prepare("EXEC SP_OBTENER_CLIENTE @Id_cliente = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertar($data) {
        $stmt = $this->conn->prepare("
            EXEC SP_INSERTAR_CLIENTE 
                @Nombre_cte = :nombre_cte,
                @Apellido_cte = :apellido_cte,
                @Email_cte = :email_cte,
                @Telefono_cte = :telefono_cte,
                @Direccion_cte = :direccion_cte
        ");
        
        return $stmt->execute([
            ':nombre_cte' => $data['nombre_cte'],
            ':apellido_cte' => $data['apellido_cte'],
            ':email_cte' => $data['email_cte'] ?? '',
            ':telefono_cte' => $data['telefono_cte'] ?? '',
            ':direccion_cte' => $data['direccion_cte'] ?? ''
        ]);
    }

    public function actualizar($data) {
        $stmt = $this->conn->prepare("
            EXEC SP_ACTUALIZAR_CLIENTE 
                @Id_cliente = :id_cliente,
                @Email_cte = :email_cte,
                @Telefono_cte = :telefono_cte,
                @Direccion_cte = :direccion_cte
        ");
        
        return $stmt->execute([
            ':id_cliente' => $data['id_cliente'],
            ':email_cte' => $data['email_cte'] ?? '',
            ':telefono_cte' => $data['telefono_cte'] ?? '',
            ':direccion_cte' => $data['direccion_cte'] ?? ''
        ]);
    }

    public function eliminar($id) {
        $stmt = $this->conn->prepare("EXEC SP_ELIMINAR_CLIENTE @Id_cliente = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
