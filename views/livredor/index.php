<?php
// page livre /index
?>
<?php include __DIR__ . '/_flash.php'; ?>

<?php include __DIR__ . '/livredor_form.php'; ?>

<section class="livredor-book">
    <h2>Le Livre d'or</h2>
    <?php if (empty($messages)): ?>
        <p>Aucun message pour le moment.</p>
    <?php else: ?>
        <nav class="book-toc">
            <h3>Table des matières</h3>
            <ul>
            <?php $j = 0; foreach ($messages as $m): $j++;
                $parts = preg_split('/\s+/', trim($m['author']));
                $initial = strtoupper(substr($parts[0] ?? '', 0, 1));
                $date = $m['created_at'] ?? '';
                // create a short excerpt (max 60 chars) from the raw content
                $rawExcerpt = strip_tags($m['content'] ?? '');
                $excerpt = mb_substr(trim(preg_replace('/\s+/', ' ', $rawExcerpt)), 0, 60, 'UTF-8');
                if (mb_strlen($rawExcerpt, 'UTF-8') > 60) $excerpt .= '…';
            ?>
                <li>
                    <a href="#" data-target-page="<?= $j ?>" class="toc-link">
                        <span class="toc-initial"><?= e($initial) ?></span>
                        <span class="toc-meta">
                            <span class="toc-name"><?= e($m['author']) ?></span>
                            <span class="toc-date"><?= e($date) ?></span>
                            <span class="toc-excerpt"><?= e($excerpt) ?></span>
                        </span>
                    </a>
                </li>
            <?php endforeach; ?>
            </ul>
        </nav>

        <div class="book" data-total-pages="<?= count($messages) ?>">
            <div class="book-inner">
                <?php $i = 0; foreach ($messages as $msg): $i++;
                    $parts = preg_split('/\s+/', trim($msg['author']));
                    $initial = strtoupper(substr($parts[0] ?? '', 0, 1));
                    // work with raw content from DB, escape once when outputting
                    $raw = $msg['content'] ?? '';
                    $escaped = e($raw);
                    // for the dropcap we need first unicode char and the rest
                    $firstChar = mb_substr($raw, 0, 1, 'UTF-8');
                    $rest = mb_substr($raw, 1, null, 'UTF-8');
                    // escape the pieces for safe output
                    $firstCharEsc = e($firstChar);
                    $restEsc = nl2br(e($rest));
                ?>
                    <div class="book-page" data-page="<?= $i ?>">
                        <div class="page-content">
                            <header class="page-header-compact">
                                <div class="avatar"><span><?= e($initial) ?></span></div>
                                <div class="page-heading">
                                    <h3 class="page-author"><?= e($msg['author']) ?></h3>
                                    <div class="page-meta"><time><?= e($msg['created_at']) ?></time></div>
                                </div>
                            </header>
                            <article class="page-body"><span class="dropcap"><?= $firstCharEsc ?></span><span class="rest"><?= $restEsc ?></span></article>

                            <!-- Replies feature removed -->
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="book-controls">
                <button class="btn btn-secondary btn-prev">&larr; Précédent</button>
                <div class="page-indicator">Page <span class="current">1</span> / <span class="total"><?= count($messages) ?></span></div>
                <button class="btn btn-primary btn-next">Suivant &rarr;</button>
            </div>
        </div>
    <?php endif; ?>
</section>

<?php // include book script (app.js already handles form UX); book.js handles pages ?>
<?php if (isset($route) && ($route === 'livredor' || strpos($route, 'livredor/') === 0)) : ?>
    <script src="/assets/js/book.js"></script>
<?php endif; ?>
