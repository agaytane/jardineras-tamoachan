<div class="container mt-5">
    <h1 class="mb-4">Empleados Registrados</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
               
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Puesto</th>
                    <th>Salario</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($empleados as $row): ?>
                <tr>
                    
                    <td><?= $row['Nombre_emp'] ?></td>
                    <td><?= $row['Apellido_emp'] ?></td>
                    <td><?= $row['Email_emp'] ?></td>
                    <td><?= $row['Telefono_emp'] ?></td>
                    <td><?= $row['Puesto'] ?></td>
                    <td>$<?= number_format($row['Salario'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
