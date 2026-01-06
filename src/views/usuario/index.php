<div class="contenedor-vista">
    <div class="encabezado-pagina">
        <h1>👥 <?= htmlspecialchars($titulo ?? 'Usuarios', ENT_QUOTES, 'UTF-8') ?></h1>
        <p class="subtitulo">Gestión de usuarios del sistema</p>
    </div>

    <div class="tarjeta-listado">
        <div class="grid-botones">
            <a href="/USUARIOS/VER" class="btn-accion btn-primario">📋 Ver Usuarios</a>
            <a href="/USUARIOS/CREAR" class="btn-accion btn-secundario">➕ Crear Usuario</a>
            <a href="/USUARIOS/EDITAR" class="btn-accion btn-terciario">✏️ Editar Usuario</a>
            <a href="/USUARIOS/PASSWORD" class="btn-accion btn-terciario">🔑 Cambiar Contraseña</a>
            <a href="/USUARIOS/ELIMINAR" class="btn-accion btn-peligro">🗑️ Eliminar Usuario</a>
        </div>
    </div>
</div>
