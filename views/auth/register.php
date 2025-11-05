<div class="auth-container">
    <div class="auth-card">
        <h1>Inscription</h1>

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

        <form method="POST" action="<?php echo url('auth/do-register'); ?>" class="auth-form">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

            <div class="form-group">
                <label for="first_name">Prénom</label>
                <input
                    type="text"
                    id="first_name"
                    name="first_name"
                    required
                    autofocus
                    placeholder="Votre prénom">
            </div>

            <div class="form-group">
                <label for="last_name">Nom</label>
                <input
                    type="text"
                    id="last_name"
                    name="last_name"
                    required
                    placeholder="Votre nom">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    placeholder="votre@email.com">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    placeholder="Au moins 6 caractères"
                    minlength="6">
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirmer le mot de passe</label>
                <input
                    type="password"
                    id="password_confirm"
                    name="password_confirm"
                    required
                    placeholder="Répéter le mot de passe"
                    minlength="6">
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                S'inscrire
            </button>
        </form>

        <p class="auth-footer">
            Vous avez déjà un compte ?
            <a href="<?php echo url('auth/login'); ?>">Se connecter</a>
        </p>
    </div>
</div>