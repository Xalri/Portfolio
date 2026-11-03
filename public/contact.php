<?php

require_once __DIR__ . '/../bootstrap.php';

$view->partial('layout/top', [
    'title' => 'Xalri - Portfolio',
    'active' => 'contact',
    'css' => 'css/contact.css',
]);
?>
    <main>
        <section id="contact" class="animate from-rotating-left">
            <h2 class="contact-title" <?= $view->i18n('contact.title') ?>><?= $view->t('contact.title') ?></h2>
            <p class="contact-description" <?= $view->i18n('contact.text') ?>><?= $view->t('contact.text') ?></p>
            <form id="contact-form" action="/send-message" method="POST">
                <div class="form-group">
                    <label for="name" <?= $view->i18n('contact.name') ?>><?= $view->t('contact.name') ?></label>
                    <input type="text" id="name" name="name" maxlength="100" required>
                </div>
                <div class="form-group">
                    <label for="email" <?= $view->i18n('contact.email') ?>><?= $view->t('contact.email') ?></label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message" <?= $view->i18n('contact.message') ?>><?= $view->t('contact.message') ?></label>
                    <textarea id="message" name="message" rows="5" maxlength="5000" required></textarea>
                </div>
                <!-- Left empty by people, filled by spam bots: send-message.php drops those messages -->
                <div class="form-trap" aria-hidden="true">
                    <label for="website">Website</label>
                    <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                </div>
                <button type="submit" class="submit-button" <?= $view->i18n('contact.send') ?>><?= $view->t('contact.send') ?></button>
            </form>
        </section>
    </main>

<?php $view->partial('layout/bottom', ['scripts' => ['js/contact.js']]);
