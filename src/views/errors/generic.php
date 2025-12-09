<div class="container mt-5">
    <div class="alert alert-danger" role="alert">
        <?= isset($message) ? htmlspecialchars($message) : 'Ha ocurrido un error inesperado.' ?>
    </div>
    
    <?php if (isset($button) && is_array($button)): ?>
        <div class="mt-3">
            <a href="<?= htmlspecialchars($button['url']) ?>" class="btn btn-secondary">
                <?= htmlspecialchars($button['text']) ?>
            </a>
        </div>
    <?php else: ?>
        <div class="mt-3">
            <a href="javascript:history.back()" class="btn btn-secondary">Volver</a>
        </div>
    <?php endif; ?>
</div>
