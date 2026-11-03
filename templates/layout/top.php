<?php
/**
 * Start of every page, down to the header: $title, $active (the nav entry of the page: home, projects, blog or
 * contact; none on the others), $css (the page's stylesheet in public/, optional), $favicon (optional),
 * $description (for search engines and link previews, optional).
 *
 * @var Portfolio\View $view
 * @var array $site
 */

use Portfolio\View;

$active ??= null;
$css ??= null;
$favicon ??= '/img/logo-background.png';
$description ??= null;
$analytics = $site['analytics'];

$nav = [
    'home' => '/',
    'projects' => '/projects',
    'blog' => '/blog',
    'contact' => '/contact',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= View::e($title) ?></title>
<?php if ($description !== null): ?>
    <meta name="description" content="<?= View::e($description) ?>">
<?php endif; ?>
    <link rel="alternate" type="application/rss+xml" title="Xalri - Blog" href="/blog/feed">
    <link rel="stylesheet" href="<?= $view->asset('style.css') ?>">
<?php if ($css !== null): ?>
    <link rel="stylesheet" href="<?= $view->asset($css) ?>">
<?php endif; ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Limelight|Nunito+Sans|Lexend">
    <link rel="icon" type="image/x-icon" href="<?= View::e($favicon) ?>">
    <script defer src="<?= View::e($analytics['umami_src']) ?>" data-website-id="<?= View::e($analytics['umami_website_id']) ?>"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= View::e($analytics['google_tag']) ?>"></script>
    <script defer src="<?= $view->asset('js/analytics.js') ?>" data-google-tag="<?= View::e($analytics['google_tag']) ?>"></script>
</head>
<body class="language-switch visible">
    <header>
        <h1><img src="/img/logo.png" alt="">alri</h1>
        <nav>
            <ul>
<?php foreach ($nav as $key => $href): ?>
                <li><a href="<?= $href ?>"<?= $key === $active ? ' class="active"' : '' ?> <?= $view->i18n("nav.$key") ?>><?= $view->t("nav.$key") ?></a></li>
<?php endforeach; ?>
                <li class="lang-switch">
                    <a href="#" class="lang-switch"><img src="/img/globe.svg" alt="">
                        <div class="lang-bubble" <?= $view->i18n('lang.switch') ?>><?= $view->t('lang.switch') ?></div>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="links">
            <a href="#" class="lang-switch"><img src="/img/globe.svg" alt="">
                <div class="lang-bubble" <?= $view->i18n('lang.switch') ?>><?= $view->t('lang.switch') ?></div>
            </a>

            <a href="https://github.com/Xalri" target="_blank" aria-label="GitHub">
                <?php $view->partial('layout/github-icon'); ?>
            </a>
            <a class="cv">Mon CV</a>
        </div>
    </header>

    <button id="go-up" aria-label="Back to top">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#EEEEEE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up">
            <line x1="12" y1="19" x2="12" y2="5"></line>
            <polyline points="5 12 12 5 19 12"></polyline>
        </svg>
    </button>
