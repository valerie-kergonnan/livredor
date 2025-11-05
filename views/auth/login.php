<div class="auth-container">
    <div class="auth-card">
        <h1>Connexion</h1>

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

        <form method="POST" action="<?php echo url('auth/do-login'); ?>" class="auth-form">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    autofocus
                    placeholder="votre@email.com">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    placeholder="••••••••">
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                Se connecter
            </button>
        </form>

        <p class="auth-footer">
            Pas encore de compte ?
            <a href="<?php echo url('auth/register'); ?>">S'inscrire</a>
        </p>
    </div>
</div>