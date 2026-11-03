<?php

require_once __DIR__ . '/../bootstrap.php';

$view->partial('layout/top', [
    'title' => 'Xalri - Portfolio',
    'active' => 'blog',
    'css' => 'css/blog.css',
]);
?>
    <main class="fade-in">
        <section id="coming-soon">
            <h2 class="coming-soon-title" <?= $view->i18n('blog.title') ?>><?= $view->t('blog.title') ?></h2>
            <p class="coming-soon-description" <?= $view->i18n('blog.text') ?>><?= $view->t('blog.text') ?></p>
            <a href="/" class="coming-soon-link" <?= $view->i18n('back_home') ?>><?= $view->t('back_home') ?></a>
        </section>
    </main>

<?php $view->partial('layout/bottom');
