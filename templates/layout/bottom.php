<?php
/**
 * End of every page, from the footer: $scripts (the page's own scripts in public/, run after script.js).
 *
 * @var Portfolio\View $view
 */

$scripts ??= [];

$socials = [
    ['href' => 'https://github.com/Xalri', 'icon' => 'github', 'label' => 'GitHub'],
    ['href' => 'https://twitch.com/XalriTV', 'icon' => 'twitch', 'label' => 'Twitch'],
    ['href' => 'https://linkedin.com', 'icon' => 'linkedin', 'label' => 'LinkedIn'],
];
?>
    <footer>
        <div class="footer-container">
            <div class="footer-about">
                <h3 <?= $view->i18n('footer.about.title') ?>><?= $view->t('footer.about.title') ?></h3>
                <p <?= $view->i18n('footer.about.text') ?>><?= $view->t('footer.about.text') ?></p>
            </div>

            <div class="footer-links">
                <h3 <?= $view->i18n('footer.links.title') ?>><?= $view->t('footer.links.title') ?></h3>
                <ul>
<?php foreach (['home' => '/', 'projects' => '/projects', 'blog' => '/blog', 'contact' => '/contact'] as $key => $href): ?>
                    <li><a href="<?= $href ?>" <?= $view->i18n("nav.$key") ?>><?= $view->t("nav.$key") ?></a></li>
<?php endforeach; ?>
                </ul>
            </div>

            <div class="footer-social">
                <h3 <?= $view->i18n('footer.follow.title') ?>><?= $view->t('footer.follow.title') ?></h3>
                <div class="socials-links">
<?php foreach ($socials as $social): ?>
                    <a href="<?= $social['href'] ?>" target="_blank" aria-label="<?= $social['label'] ?>">
                        <img src="/img/languages/<?= $social['icon'] ?>.svg" alt="<?= $social['label'] ?>">
                    </a>
<?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 Samy. All rights reserved.</p>
        </div>
    </footer>
    <script src="<?= $view->asset('script.js') ?>"></script>
<?php foreach ($scripts as $script): ?>
    <script src="<?= $view->asset($script) ?>"></script>
<?php endforeach; ?>
</body>
</html>
