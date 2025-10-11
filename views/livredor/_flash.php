<?php if (!empty($flash)): ?>
    <?php foreach ($flash as $type => $msgs): ?>
        <?php foreach ($msgs as $m): ?>
            <div class="flash <?= e($type) ?>"><?= e($m) ?></div>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endif; ?>
