<div class="hero">
    <div class="hero-content">
        <h1><?php e($message); ?></h1>
        <p class="hero-title">Mon livre d'or</p>
    </div>
</div>

<!-- Présentation / texte d'accueil -->
<section class="home-intro">
    <div class="home-container">
        <div class="intro-card">
            <p>Bienvenue sur notre livre d’or, un espace dédié à vos mots, vos impressions et vos émotions.

                Chaque message que vous laisserez ici est une trace précieuse, un souvenir partagé, un écho de votre passage. Vos témoignages nous touchent, nous inspirent et donnent vie à ce lieu à travers vos regards et vos expériences.

                Prenez un instant pour écrire quelques lignes, un simple merci, une pensée, ou même un souvenir marquant. Ces mots, petits ou grands, font partie de l’histoire que nous construisons ensemble.

                Merci de votre visite et de votre confiance. Laissez parler votre cœur… votre plume est la plus belle des empreintes.</p>
        </div>
    </div>
</section>

<section class="features">
    <div class="container">

        <div class="features-grid">
            <?php if (!empty($features) && is_array($features)): ?>
                <?php foreach ($features as $feature): ?>
                    <div class="feature-card">
                        <i class="fas fa-check-circle"></i>
                        <h3><?php e($feature); ?></h3>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Pas de fonctionnalités définies — ne rien afficher. -->
            <?php endif; ?>
        </div>
    </div>
</section>