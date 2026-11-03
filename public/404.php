<?php

// Apache's error page for unknown URLs (see .htaccess), and project.php's for unknown projects

require_once __DIR__ . '/../bootstrap.php';

$view->partial('layout/top', [
    'title' => 'Xalri - Portfolio',
    'css' => 'css/404.css',
]);
?>
    <main class="fade-in">
        <section id="error">
            <h2 class="error-title" <?= $view->i18n('error.title') ?>><?= $view->t('error.title') ?></h2>
            <p class="error-description" <?= $view->i18n('error.text') ?>><?= $view->t('error.text') ?></p>
            <a href="/" class="error-link" <?= $view->i18n('back_home') ?>><?= $view->t('back_home') ?></a>
        </section>
    </main>

<?php $view->partial('layout/bottom');
