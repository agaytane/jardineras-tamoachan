<?php
class EmpleadoModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function listar() {
        $stmt = $this->conn->prepare("EXEC SP_LISTAR_EMPLEADOS");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($id) {
        $stmt = $this->conn->prepare("EXEC SP_OBTENER_EMPLEADO @Id_empleado = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertar($data) {
        $stmt = $this->conn->prepare("
            EXEC SP_INSERTAR_EMPLEADO 
                @Nombre_emp = :nombre_emp,
                @Apellido_emp = :apellido_emp,
                @Email_emp = :email_emp,
                @Telefono_emp = :telefono_emp,
                @Puesto = :puesto,
                @Salario = :salario,
                @Nombre_jefe = :nombre_jefe,
                @Fk_id_oficina = :fk_id_oficina
        ");
        
        return $stmt->execute([
            ':nombre_emp' => $data['nombre_emp'],
            ':apellido_emp' => $data['apellido_emp'],
            ':email_emp' => $data['email_emp'] ?? '',
            ':telefono_emp' => $data['telefono_emp'] ?? '',
            ':puesto' => $data['puesto'] ?? '',
            ':salario' => $data['salario'] ?? 0,
            ':nombre_jefe' => $data['nombre_jefe'] ?? '',
            ':fk_id_oficina' => $data['fk_id_oficina'] ?? null
        ]);
    }

    public function actualizar($data) {
        $stmt = $this->conn->prepare("
            EXEC SP_ACTUALIZAR_EMPLEADO 
                @Id_empleado = :id_empleado,
                @Email_emp = :email_emp,
                @Telefono_emp = :telefono_emp,
                @Puesto = :puesto,
                @Salario = :salario,
                @Nombre_jefe = :nombre_jefe,
                @Fk_id_oficina = :fk_id_oficina
        ");
        
        return $stmt->execute([
            ':id_empleado' => $data['id_empleado'],
            ':email_emp' => $data['email_emp'] ?? '',
            ':telefono_emp' => $data['telefono_emp'] ?? '',
            ':puesto' => $data['puesto'] ?? '',
            ':salario' => $data['salario'] ?? 0,
            ':nombre_jefe' => $data['nombre_jefe'] ?? '',
            ':fk_id_oficina' => $data['fk_id_oficina'] ?? null
        ]);
    }

    public function eliminar($id) {
        $stmt = $this->conn->prepare("EXEC SP_ELIMINAR_EMPLEADO @Id_empleado = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function obtenerOficinas() {
        $stmt = $this->conn->prepare("EXEC SP_LISTAR_OFICINAS");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>