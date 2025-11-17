<?php

$server   = "sqlserver";   // nombre del contenedor o servidor
$port     = "1433";        // puerto de SQL Server
$db       = "AGE_JARDINES_TAMOANCHAN";
$username = "sa";
$password = "Admin123!";

try {
    $conn = new PDO(
        "sqlsrv:Server=$server,$port;Database=$db;Encrypt=no;TrustServerCertificate=yes;",
        $username,
        $password
    );

    // Activar errores
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conectado correctamente a SQL Server";

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

?>
