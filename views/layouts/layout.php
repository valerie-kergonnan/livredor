<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Livre d'or</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <header class="header">
        <div class="navbar container">
            <div class="nav-brand">
                <a href="<?= url('') ?>">
                    <img src="/assets/images/logo.svg" alt="logo" class="site-logo">
                </a>
            </div>

            <nav class="nav-menu">
                <a href="<?= url('') ?>" class="btn btn-primary">Accueil</a>
                <a href="<?= url('livredor') ?>" class="btn btn-secondary">Voir le livre d'or</a>
                <?php if (is_logged_in()): ?>
                    <a href="<?= url('auth/profile') ?>" class="btn btn-outline">Profil</a>
                    <a href="<?= url('auth/logout') ?>" class="btn btn-outline">Déconnexion</a>
                <?php else: ?>
                    <a href="<?= url('auth/register') ?>" class="btn btn-outline">Inscription</a>
                    <a href="<?= url('auth/login') ?>" class="btn btn-outline">Connexion</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="container content">
            <div class="content-grid">
                <div class="content-main">
                    <?php echo $content; ?>
                </div>


            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container footer-content">
            <p>&copy; <?= date('Y') ?> - Livre d'or — fait avec ❤️ par valerie</p>
        </div>
    </footer>
    <?php
    // inclure le JS uniquement sur la page livredor
    if (isset($route) && ($route === 'livredor' || strpos($route, 'livredor/') === 0)) :
    ?>
        <script src="/assets/js/app.js"></script>
    <?php endif; ?>
</body>

</html>