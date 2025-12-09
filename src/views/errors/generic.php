<div class="container mt-5 text-center">
    <?php if (isset($icon)): ?>
        <div style="font-size: 3rem; margin-bottom: 1rem;"><?= htmlspecialchars($icon) ?></div>
    <?php endif; ?>

    <?php if (isset($title)): ?>
        <h1 class="mb-3"><?= htmlspecialchars($title) ?></h1>
    <?php endif; ?>

    <div class="alert alert-danger" role="alert">
        <?= isset($message) ? htmlspecialchars($message) : 'Ha ocurrido un error inesperado.' ?>
    </div>
    
    <?php if (isset($button) && is_array($button)): ?>
        <div class="mt-4">
            <a href="<?= htmlspecialchars($button['url']) ?>" class="btn btn-secondary">
                <?= htmlspecialchars($button['text']) ?>
            </a>
        </div>
    <?php else: ?>
        <div class="mt-4">
            <a href="javascript:history.back()" class="btn btn-secondary">Volver</a>
        </div>
    <?php endif; ?>
</div>
