<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>👥 Usuarios</h1>
        <p class="subtitulo">Listado de usuarios del sistema</p>
    </div>

    <div class="tarjeta-listado">
        <div class="encabezado-tabla">
            <h2>Usuarios Registrados</h2>
            <a href="/USUARIOS/CREAR" class="btn-accion btn-primario">➕ Nuevo Usuario</a>
        </div>

        <?php if (empty($usuarios)): ?>
            <div style="text-align: center; padding: 60px 20px; color: #666;">
                <div style="font-size: 48px; margin-bottom: 20px;">👤</div>
                <h3 style="color: #333; margin-bottom: 10px;">No hay usuarios registrados</h3>
                <p style="margin-bottom: 25px;">Comienza agregando un nuevo usuario al sistema</p>
                <a href="/USUARIOS/CREAR" class="btn-accion btn-primario">➕ Crear Primer Usuario</a>
            </div>
        <?php else: ?>
            <table class="tabla-jardin">
                <thead>
                    <tr>
                        <th style="width: 200px;">Usuario</th>
                        <th style="width: 150px;">Rol</th>
                        <th style="width: 120px;">Estado</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['Usuario'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <span class="badge-estado badge-activo">
                                <?= htmlspecialchars($u['Nombre_rol'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($u['Activo']): ?>
                                <span class="badge-estado badge-activo">✓ Activo</span>
                            <?php else: ?>
                                <span class="badge-estado badge-inactivo">✗ Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($u['Descripcion_rol'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
