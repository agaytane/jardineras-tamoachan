<?php
// Variables desde Ctrl_Vistas::resultado
$tipo = $tipo ?? 'exito';
$accion = $accion ?? 'operación';
$entidad = $entidad ?? 'Registro';
$ruta = $ruta ?? null; // Ej: CLIENTES, PRODUCTOS, PEDIDOS
$mensaje = $mensaje ?? null;
$detalle = $detalle ?? null;

$esError = strtolower($tipo) === 'error';
$icono = $esError ? '❌' : '✅';
$titulo = $esError ? 'Operación con errores' : 'Operación exitosa';
$colorClase = $esError ? 'alert-danger' : 'alert-success';
$volver = $ruta ? '/' . $ruta : '/INICIO';
?>

<div class="contenedor-vista">
  <div class="encabezado-pagina">
    <h2><?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?></h2>
    <p class="texto-secundario">
      <?= $icono ?>
      <?= htmlspecialchars(ucfirst($accion), ENT_QUOTES, 'UTF-8') ?>
      de <?= htmlspecialchars($entidad, ENT_QUOTES, 'UTF-8') ?>
    </p>
  </div>

  <div class="tarjeta-formulario" style="max-width: 840px; margin: 0 auto;">
    <div class="alert <?= $colorClase ?>" role="alert" style="font-size: 1rem;">
      <strong><?= $icono ?></strong>
      <?= htmlspecialchars($mensaje ?? ($esError ? 'Ocurrió un error.' : 'Se completó correctamente.'), ENT_QUOTES, 'UTF-8') ?>
    </div>

    <?php if (!empty($detalle)) : ?>
      <div class="tarjeta-listado" style="margin-top: 12px;">
        <h5 style="margin-bottom:8px;">Detalle</h5>
        <p style="white-space: pre-wrap;"><?= htmlspecialchars($detalle, ENT_QUOTES, 'UTF-8') ?></p>
      </div>
    <?php endif; ?>

    <div style="display:flex; gap:12px; margin-top: 16px;">
      <a href="<?= htmlspecialchars($volver, ENT_QUOTES, 'UTF-8') ?>" class="btn btn-primary">Regresar</a>
      <a href="/INICIO" class="btn btn-outline-secondary">Ir al inicio</a>
    </div>
  </div>
</div>
