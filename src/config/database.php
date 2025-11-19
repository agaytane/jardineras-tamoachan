<?php
$serverName = "sqlserver";
$port = "1433";
$db = "JARDINES_TAMOANCHAN";
$username = "sa";
$password = "Admin123!";

try {
    $conn = new PDO(
        "sqlsrv:Server=$serverName,$port;Database=$db;Encrypt=no;TrustServerCertificate=yes;",
        $username,
        $password
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Error en la conexión a SQL Server: " . $e->getMessage());
}

