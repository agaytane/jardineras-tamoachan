<?php
/**
 * Map SQL Server/ODBC PDO errors to friendly Spanish messages.
 */
function map_pdo_error($e, $entity = 'Registro', $action = 'operación') {
    $sqlstate = null;
    $number = null;
    $msg = null;

    if ($e instanceof PDOException && isset($e->errorInfo) && is_array($e->errorInfo)) {
        $sqlstate = $e->errorInfo[0] ?? null; // e.g., '23000'
        $number   = $e->errorInfo[1] ?? null; // SQL Server error number (e.g., 547)
        $msg      = $e->errorInfo[2] ?? $e->getMessage();
    } else {
        $msg = $e->getMessage();
    }

    $phrase = association_phrase($entity);

    // Default
    $userMessage = "❌ Error al $action $entity.";
    $detail = null;

    // Foreign key constraint violation (cannot delete/update due to references)
    if ($number === 547 || ($sqlstate === '23000' && strpos(strtolower((string)$msg), 'constraint') !== false)) {
        $userMessage = "❌ No se puede $action el $entity, $phrase.";
        return [$userMessage, null];
    }

    // Duplicate key / unique constraint
    if ($number === 2627 || $number === 2601 || ($sqlstate === '23000' && strpos(strtolower((string)$msg), 'unique') !== false)) {
        $userMessage = "❌ Ya existe un $entity con esos datos.";
        return [$userMessage, null];
    }

    // Cannot insert NULL into column
    if ($number === 515) {
        $userMessage = "❌ Faltan datos obligatorios.";
        return [$userMessage, null];
    }

    // Conversion/type errors
    if ($number === 8114 || $number === 245) {
        $userMessage = "❌ Tipos de datos inválidos.";
        return [$userMessage, null];
    }

    // Deadlock victim
    if ($number === 1205) {
        $userMessage = "❌ Operación interrumpida por concurrencia, intente de nuevo.";
        return [$userMessage, null];
    }

    // Fallback generic without leaking driver internals
    return [$userMessage, null];
}

function association_phrase($entity) {
    switch (strtolower($entity)) {
        case 'cliente':
            return 'tiene pedidos asociados';
        case 'empleado':
            return 'tiene pedidos asociados';
        case 'producto':
            return 'está asociado a detalles de pedidos';
        case 'gama':
            return 'está asociada a productos';
        case 'oficina':
            return 'está asociada a empleados';
        case 'pedido':
            return 'tiene detalles asociados';
        default:
            return 'tiene registros asociados';
    }
}
