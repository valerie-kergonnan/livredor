<?php
// views/livredor/show.php
// Affiche une page individuelle pour un message
?>

<section class="livredor-single">
    <div class="container">
        <div class="single-card">
            <header class="page-header-compact">
                <div class="avatar"><span><?php echo e(strtoupper(mb_substr($message['author'], 0, 1))); ?></span></div>
                <div class="page-heading">
                    <h2 class="page-author"><?php echo e($message['author']); ?></h2>
                    <div class="page-meta"><time><?php echo e($message['created_at']); ?></time></div>
                </div>
            </header>

            <article class="page-body">
                <?php echo nl2br(e($message['content'])); ?>
            </article>

            <p><a href="<?php echo url('livredor'); ?>" class="btn btn-secondary">Retour au livre</a></p>
            <div class="single-nav" style="margin-top:1rem; display:flex; gap:0.5rem;">
                <?php if (!empty($prev)): ?>
                    <a class="btn btn-secondary" href="<?php echo url('livredor/show/' . $prev['id']); ?>">&larr; Précédent</a>
                <?php endif; ?>
                <?php if (!empty($next)): ?>
                    <a class="btn btn-primary" href="<?php echo url('livredor/show/' . $next['id']); ?>">Suivant &rarr;</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
