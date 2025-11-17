<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Empleados</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #333; color: white; }
    </style>
</head>
<body>

<h1>Empleados registrados</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Email</th>
        <th>Teléfono</th>
        <th>Puesto</th>
        <th>Salario</th>
    </tr>

    <?php foreach ($empleados as $row): ?>
    <tr>
        <td><?= $row['Id_empleado'] ?></td>
        <td><?= $row['Nombre_emp'] ?></td>
        <td><?= $row['Apellido_emp'] ?></td>
        <td><?= $row['Email_emp'] ?></td>
        <td><?= $row['Telefono_emp'] ?></td>
        <td><?= $row['Puesto'] ?></td>
        <td><?= $row['Salario'] ?></td>
    </tr>
    <?php endforeach; ?>

</table>

</body>
</html>
