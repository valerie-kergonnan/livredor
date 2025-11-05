<?php
// views/livredor/show_partial.php
// Partial used for AJAX modal display
?>
<div class="modal-card">
    <header class="page-header-compact">
        <div class="avatar"><span><?php echo e(strtoupper(mb_substr($message['author'], 0, 1))); ?></span></div>
        <div class="page-heading">
            <h3 class="page-author"><?php echo e($message['author']); ?></h3>
            <div class="page-meta"><time><?php echo e($message['created_at']); ?></time></div>
        </div>
    </header>

    <article class="page-body">
        <?php echo nl2br(e($message['content'])); ?>
    </article>
    <div class="modal-nav" style="margin-top:1rem; display:flex; gap:0.5rem;">
        <?php if (!empty($prevMessage)): ?>
            <a class="btn btn-secondary ajax-view" href="<?php echo url('livredor/show/' . $prevMessage['id'] . '?ajax=1'); ?>">&larr; Précédent</a>
        <?php endif; ?>
        <?php if (!empty($nextMessage)): ?>
            <a class="btn btn-primary ajax-view" href="<?php echo url('livredor/show/' . $nextMessage['id'] . '?ajax=1'); ?>">Suivant &rarr;</a>
        <?php endif; ?>
    </div>
</div>
