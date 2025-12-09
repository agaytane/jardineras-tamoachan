<?php
namespace App\Models;

use PDO;
use PDOException;

class EmpleadoModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // ✅ LISTAR
    public function listar() {
        try {
            $sql = "SELECT * FROM EMPLEADO";
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
            $sql = "SELECT * FROM EMPLEADO WHERE Id_empleado = :id";
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
            $sql = "INSERT INTO EMPLEADO 
                (Id_empleado, Nombre_emp, Apellido_emp, Email_emp, Telefono_emp, Puesto, Salario, Nombre_jefe, Fk_id_oficina)
                VALUES 
                (:id, :nom, :ape, :email, :tel, :puesto, :sal, :jefe, :ofi)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":id", $data['Id_empleado']);
            $stmt->bindParam(":nom", $data['Nombre_emp']);
            $stmt->bindParam(":ape", $data['Apellido_emp']);
            $stmt->bindParam(":email", $data['Email_emp']);
            $stmt->bindParam(":tel", $data['Telefono_emp']);
            $stmt->bindParam(":puesto", $data['Puesto']);
            $stmt->bindParam(":sal", $data['Salario']);
            $stmt->bindParam(":jefe", $data['Nombre_jefe']);
            $stmt->bindParam(":ofi", $data['Fk_id_oficina']);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // ✅ ACTUALIZAR
    public function actualizar($data) {
        try {
            $sql = "UPDATE EMPLEADO SET 
                Nombre_emp = :nom,
                Apellido_emp = :ape,
                Email_emp = :email,
                Telefono_emp = :tel,
                Puesto = :puesto,
                Salario = :sal,
                Nombre_jefe = :jefe,
                Fk_id_oficina = :ofi
                WHERE Id_empleado = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":id", $data['Id_empleado']);
            $stmt->bindParam(":nom", $data['Nombre_emp']);
            $stmt->bindParam(":ape", $data['Apellido_emp']);
            $stmt->bindParam(":email", $data['Email_emp']);
            $stmt->bindParam(":tel", $data['Telefono_emp']);
            $stmt->bindParam(":puesto", $data['Puesto']);
            $stmt->bindParam(":sal", $data['Salario']);
            $stmt->bindParam(":jefe", $data['Nombre_jefe']);
            $stmt->bindParam(":ofi", $data['Fk_id_oficina']);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // ✅ ELIMINAR
    public function eliminar($id) {
        try {
            $sql = "DELETE FROM EMPLEADO WHERE Id_empleado = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
