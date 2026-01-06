<?php
class UsuarioModel {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function login($usuario, $password) {
        try {
            $sql = "SELECT 
                        U.Id_usuario, 
                        U.Usuario, 
                        U.Password, 
                        R.Nombre_rol
                    FROM USUARIOS U
                    INNER JOIN ROLES R ON U.Fk_id_rol = R.Id_rol
                    WHERE U.Usuario = ? 
                    AND U.Activo = 1";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$usuario]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return false;
            }

            // Validación de password (texto plano por ahora)
            if ($password !== $user["Password"]) {
                return false;
            }

            return $user;

        } catch (PDOException $e) {
            return false;
        }
    }

    public function listar() {
        $stmt = $this->conn->prepare("EXEC SP_LISTAR_USUARIOS");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($id) {
        $stmt = $this->conn->prepare("EXEC SP_OBTENER_USUARIO @Id_usuario = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertar($data) {
        $stmt = $this->conn->prepare("
            EXEC SP_INSERTAR_USUARIO 
                @Usuario = :usuario,
                @Password = :password,
                @Fk_id_rol = :fk_id_rol
        ");
        
        return $stmt->execute([
            ':usuario' => $data['usuario'],
            ':password' => $data['password'],
            ':fk_id_rol' => $data['fk_id_rol']
        ]);
    }

    public function actualizar($data) {
        $stmt = $this->conn->prepare("
            EXEC SP_ACTUALIZAR_USUARIO 
                @Id_usuario = :id_usuario,
                @Fk_id_rol = :fk_id_rol,
                @Activo = :activo
        ");
        
        return $stmt->execute([
            ':id_usuario' => $data['id_usuario'],
            ':fk_id_rol' => $data['fk_id_rol'],
            ':activo' => $data['activo']
        ]);
    }

    public function cambiarPassword($id, $password) {
        $stmt = $this->conn->prepare("
            EXEC SP_CAMBIAR_PASSWORD 
                @Id_usuario = :id,
                @Password = :password
        ");
        
        return $stmt->execute([
            ':id' => $id,
            ':password' => $password
        ]);
    }

    public function eliminar($id) {
        $stmt = $this->conn->prepare("EXEC SP_ELIMINAR_USUARIO @Id_usuario = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function listarRoles() {
        $stmt = $this->conn->prepare("EXEC SP_LISTAR_ROLES");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

