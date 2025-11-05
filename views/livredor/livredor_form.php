<?php
// views/livredor/livredor_form.php
// Partial: formulaire d'ajout pour le livre d'or
// Incluez ce fichier dans `views/livredor/index.php` via:
//   include VIEW_PATH . '/livredor/livredor_form.php';

// IDE helper: declare url() for static analyzers (in runtime the real function
// from your helpers will be used). This avoids "Undefined function 'url'" warnings.
if (!function_exists('url')) {
    /**
     * Generate an application URL (IDE stub).
     * @param string $path
     * @return string
     */
    function url($path = '') { return (string) $path; }
}
?>

<section class="message-form">
    <h2>Ajouter un message</h2>
    <form method="post" action="<?php echo url('livredor/store'); ?>">
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

        <div>
            <label for="author">Nom</label>
            <input id="author" name="author" type="text" required>
        </div>

        <div>
            <label for="content">Message</label>
            <textarea id="content" name="content" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-submit">Ajouter</button>
    </form>
</section>
