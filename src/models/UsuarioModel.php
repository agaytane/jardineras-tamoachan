<?php
namespace App\Models;

use PDO;
use PDOException;

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

            // ⚠ VALIDACIÓN (tú usas contraseñas en texto plano)
            if ($password !== $user["Password"]) {
                return false;
            }

            return $user;

        } catch (PDOException $e) {
            return false;
        }
    }
}
