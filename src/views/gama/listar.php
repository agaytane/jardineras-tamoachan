<div class="container mt-5">
    <h2>Listado de Gamas</h2>

    <a href="/GAMA/CREAR" class="btn btn-success mb-3">➕ Nueva Gama</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($gamas as $g): ?>
            <tr>
                <td><?= $g['Id_gama'] ?></td>
                <td><?= $g['Nombre_gama'] ?></td>
                <td><?= $g['Descripcion_gama'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
