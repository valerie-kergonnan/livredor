<div class="profile-container">
    <div class="profile-card">
        <h1>Mon profil</h1>

        <?php if (!empty($flash)): ?>
            <?php foreach ($flash as $type => $messages): ?>
                <?php if (is_array($messages)): ?>
                    <?php foreach ($messages as $message): ?>
                        <div class="flash <?php echo e($type); ?>">
                            <?php echo e($message); ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="profile-info">
            <div class="info-row">
                <span class="label">Prénom :</span>
                <span class="value"><?php echo e($user['first_name']); ?></span>
            </div>

            <div class="info-row">
                <span class="label">Nom :</span>
                <span class="value"><?php echo e($user['last_name']); ?></span>
            </div>

            <div class="info-row">
                <span class="label">Email :</span>
                <span class="value"><?php echo e($user['email']); ?></span>
            </div>

            <div class="info-row">
                <span class="label">Membre depuis :</span>
                <span class="value">
                    <?php
                    if (isset($user['created_at'])) {
                        echo date('d/m/Y', strtotime($user['created_at']));
                    }
                    ?>
                </span>
            </div>
        </div>

        <div class="profile-actions">
            <a href="<?php echo url('livredor'); ?>" class="btn btn-secondary">
                Voir le livre d'or
            </a>
            <a href="<?php echo url('auth/logout'); ?>" class="btn btn-outline">
                Se déconnecter
            </a>
        </div>
    </div>
</div>