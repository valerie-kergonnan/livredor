<?php
// views/livredor/index.php
// Page principale du livre d'or — affiche le formulaire et chaque message comme une page
?>

<?php if (!empty($flash)): ?>
    <?php foreach ($flash as $type => $msgs): ?>
        <?php foreach ((array) $msgs as $msg): ?>
            <div class="alert alert-<?php echo e($type); ?>"><?php echo e($msg); ?></div>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php // include the form partial ?>
<?php include VIEW_PATH . '/livredor/livredor_form.php'; ?>

<section class="livredor-book">
    <h2>Le Livre d'or</h2>

    <div class="book" data-total-pages="<?php echo count($messages); ?>">
        <div class="book-inner">
            <?php foreach ($messages as $i => $m): $page = $i + 1; ?>
                <div class="book-page" data-page="<?php echo $page; ?>" <?php echo ($i === 0) ? 'aria-current="true"' : ''; ?>>
                    <div class="page-content">
                        <header class="page-header-compact">
                            <div class="avatar"><span><?php echo e(strtoupper(mb_substr($m['author'], 0, 1))); ?></span></div>
                            <div class="page-heading">
                                <h3 class="page-author"><a href="<?php echo url('livredor/show/' . $m['id']); ?>"><?php echo e($m['author']); ?></a></h3>
                                <div class="page-meta"><time><?php echo e($m['created_at']); ?></time></div>
                            </div>
                        </header>

                        <article class="page-body">
                            <?php $plain = trim(strip_tags($m['content'])); ?>
                            <span class="dropcap"><?php echo e(mb_substr($plain, 0, 1)); ?></span>
                            <span class="rest"><?php echo e(mb_substr($plain, 1)); ?></span>
                        </article>

                        <p style="margin-top:1rem;"><a class="btn btn-secondary ajax-view" href="<?php echo url('livredor/show/' . $m['id']); ?>?ajax=1">Voir</a></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="book-controls">
            <button class="btn btn-secondary btn-prev">&larr; Précédent</button>
            <div class="page-indicator">Page <span class="current">1</span> / <span class="total"><?php echo max(1, count($messages)); ?></span></div>
            <button class="btn btn-primary btn-next">Suivant &rarr;</button>
        </div>
        <div class="book-pager" style="margin-top:1rem; text-align:center;">
            <?php $total = max(1, count($messages)); ?>
            <?php for ($p = 1; $p <= $total; $p++): ?>
                <a href="<?php echo url('livredor') . '?page=' . $p; ?>" class="pager-link" data-page="<?php echo $p; ?>" style="display:inline-block; margin:0 4px; padding:6px 8px; border-radius:4px;"><?php echo $p; ?></a>
            <?php endfor; ?>
        </div>
    </div>

</section>

<script src="/assets/js/book.js"></script>

<!-- Modal overlay for AJAX message view -->
<div id="livredor-modal" class="livredor-modal" aria-hidden="true" style="display:none;">
    <div class="livredor-modal-backdrop"></div>
    <div class="livredor-modal-panel" role="dialog" aria-modal="true">
        <button class="livredor-modal-close" aria-label="Fermer">×</button>
        <div class="livredor-modal-content"></div>
    </div>
</div>

