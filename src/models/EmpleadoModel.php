<?php
class EmpleadoModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /* =========================
       LISTAR
    ========================== */
    public function listar() {
        $sql = "SELECT * FROM EMPLEADO";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* =========================
       OBTENER
    ========================== */
    public function obtener($id) {
        $sql = "SELECT * FROM EMPLEADO WHERE Id_empleado = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* =========================
       INSERTAR
    ========================== */
    public function insertar($data) {
        $sql = "INSERT INTO EMPLEADO
            (Nombre_emp, Apellido_emp, Email_emp, Telefono_emp, Puesto, Salario, Nombre_jefe, Fk_id_oficina)
            VALUES
            (:nom, :ape, :email, :tel, :puesto, :sal, :jefe, :ofi)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":nom", $data['Nombre_emp']);
        $stmt->bindParam(":ape", $data['Apellido_emp']);
        $stmt->bindParam(":email", $data['Email_emp']);
        $stmt->bindParam(":tel", $data['Telefono_emp']);
        $stmt->bindParam(":puesto", $data['Puesto']);
        $stmt->bindParam(":sal", $data['Salario'], PDO::PARAM_STR);
        $stmt->bindParam(":jefe", $data['Nombre_jefe']);
        $stmt->bindParam(":ofi", $data['Fk_id_oficina'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    /* =========================
       ACTUALIZAR
    ========================== */
    public function actualizar($data) {
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

        $stmt->bindParam(":id", $data['Id_empleado'], PDO::PARAM_INT);
        $stmt->bindParam(":nom", $data['Nombre_emp']);
        $stmt->bindParam(":ape", $data['Apellido_emp']);
        $stmt->bindParam(":email", $data['Email_emp']);
        $stmt->bindParam(":tel", $data['Telefono_emp']);
        $stmt->bindParam(":puesto", $data['Puesto']);
        $stmt->bindParam(":sal", $data['Salario'], PDO::PARAM_STR);
        $stmt->bindParam(":jefe", $data['Nombre_jefe']);
        $stmt->bindParam(":ofi", $data['Fk_id_oficina'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    /* =========================
       ELIMINAR
    ========================== */
    public function eliminar($id) {
        $sql = "DELETE FROM EMPLEADO WHERE Id_empleado = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
