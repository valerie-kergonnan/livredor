<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Livre d'or</title>
    <?php
    // inclure le CSS uniquement pour la route 'livredor' (ou ses sous-pages)
    $route = '';
    if (!empty($_GET['url'])) {
        $route = trim($_GET['url'], '/');
    } else {
        // fallback : extraire depuis REQUEST_URI
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        $uri = parse_url($uri, PHP_URL_PATH);
        $route = ltrim($uri, '/');
    }
    if ($route === 'livredor' || strpos($route, 'livredor/') === 0) :
    ?>
        <link rel="stylesheet" href="/assets/css/style.css">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <?php endif; ?>
</head>
<body>

    <header class="header">
        <div class="navbar container">
            <div class="nav-brand">
                <a href="<?= url('') ?>">
                    <img src="/assets/images/logo.svg" alt="logo" class="site-logo">
                </a>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li><a href="<?= url('') ?>">Accueil</a></li>
                    <li><a href="<?= url('livredor') ?>">Livre d'or</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="container content">
            <div class="content-grid">
                <div class="content-main">
                    <?php echo $content; ?>
                </div>

                <aside class="sidebar">
                    <div class="info-box">
                        <h4>À propos</h4>
                        <p>Bienvenue sur le livre d'or. Partagez un message et lisez les témoignages des autres.</p>
                    </div>
                    <div class="info-box">
                        <h4>Règles</h4>
                        <p>Pas d'insultes, pas de contenu illégal. Restez courtois.</p>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container footer-content">
            <p>&copy; <?= date('Y') ?> - Livre d'or</p>
        </div>
    </footer>

</body>
<?php
// inclure le JS uniquement sur la page livredor
if (isset($route) && ($route === 'livredor' || strpos($route, 'livredor/') === 0)) :
?>
    <script src="/assets/js/app.js"></script>
<?php endif; ?>
</html>
