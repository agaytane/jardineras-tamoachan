<?php
class ClienteModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /* =========================
       LISTAR CLIENTES
    ========================== */
    public function listar() {
        $stmt = $this->conn->prepare("EXEC SP_LISTAR_CLIENTES");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* =========================
       OBTENER CLIENTE
    ========================== */
    public function obtener($id) {
        $stmt = $this->conn->prepare("EXEC SP_OBTENER_CLIENTE :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* =========================
       INSERTAR CLIENTE
    ========================== */
    public function insertar($data) {
        $stmt = $this->conn->prepare(
            "EXEC SP_INSERTAR_CLIENTE 
             :nom, :ape, :email, :tel, :dir"
        );

        return $stmt->execute([
            ':nom'   => $data['Nombre_cte'],
            ':ape'   => $data['Apellido_cte'],
            ':email' => $data['Email_cte'],
            ':tel'   => $data['Telefono_cte'],
            ':dir'   => $data['Direccion_cte']
        ]);
    }

    /* =========================
       ACTUALIZAR CLIENTE
    ========================== */
    public function actualizar($data) {
        $stmt = $this->conn->prepare(
            "EXEC SP_ACTUALIZAR_CLIENTE 
             :id, :email, :tel, :dir"
        );

        return $stmt->execute([
            ':id'    => $data['Id_cliente'],
            ':email' => $data['Email_cte'],
            ':tel'   => $data['Telefono_cte'],
            ':dir'   => $data['Direccion_cte']
        ]);
    }

    /* =========================
       ELIMINAR CLIENTE
    ========================== */
    public function eliminar($id) {
        $stmt = $this->conn->prepare("EXEC SP_ELIMINAR_CLIENTE :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
