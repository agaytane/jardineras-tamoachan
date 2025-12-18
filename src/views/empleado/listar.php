<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>👥 Empleados</h1>
        <p class="subtitulo">Gestión de recursos humanos y personal</p>
    </div>

    <div class="tarjeta-listado">
        <div class="encabezado-tabla">
            <h2>Listado de Empleados</h2>
            <a href="/EMPLEADOS/CREAR" class="btn-accion btn-primario">➕ Nuevo Empleado</a>
        </div>

        <?php if (empty($empleados)): ?>
            <div style="text-align: center; padding: 60px 20px; color: #666;">
                <div style="font-size: 48px; margin-bottom: 20px;">📭</div>
                <h3 style="color: #333; margin-bottom: 10px;">No hay empleados registrados</h3>
                <p style="margin-bottom: 25px;">Comienza agregando un nuevo empleado al sistema</p>
                <a href="/EMPLEADOS/CREAR" class="btn-accion btn-primario">➕ Crear Primer Empleado</a>
            </div>
        <?php else: ?>
            <table class="tabla-jardin">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th style="width: 120px;">Teléfono</th>
                        <th style="width: 150px;">Puesto</th>
                        <th style="width: 100px;">Salario</th>
                        <th style="width: 120px;">Jefe</th>
                        <th style="width: 100px;">Oficina</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($empleados as $e): ?>
                    <tr>
                        <td><?= htmlspecialchars($e['Nombre_emp'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($e['Apellido_emp'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($e['Email_emp'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($e['Telefono_emp'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($e['Puesto'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td>$<?= number_format(floatval($e['Salario'] ?? 0), 2) ?></td>
                        <td><?= htmlspecialchars($e['Nombre_jefe'] ?? 'Sin jefe', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($e['Fk_id_oficina'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

