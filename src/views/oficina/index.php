<div class="container mt-5 text-center">

    <h2 class="mb-4">Panel de Gestión de <?= $titulo ?></h2>
    <p>Selecciona una acción</p>

    <div class="row justify-content-center mt-4">

        <div class="col-md-3 mb-3">
            <a href="/<?= $ruta ?>/CREAR" class="btn btn-success w-100 p-3">➕ Agregar</a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="/<?= $ruta ?>/VER" class="btn btn-primary w-100 p-3">👀 Visualizar</a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="/<?= $ruta ?>/EDITAR" class="btn btn-warning w-100 p-3">✏️ Editar</a>
        </div>

        <div class="col-md-3 mb-3">
            <a href="/<?= $ruta ?>/ELIMINAR" class="btn btn-danger w-100 p-3">🗑️ Eliminar</a>
        </div>

    </div>

    <div class="mt-4">
        <a href="/INICIO" class="btn btn-secondary">⬅ Volver al inicio</a>
    </div>

</div>
