<?php

// One post: /blog/<slug> (see .htaccess)

use Portfolio\Content\Markdown;
use Portfolio\Content\PostRepository;
use Portfolio\I18n\Translator;
use Portfolio\View;

require_once __DIR__ . '/../bootstrap.php';

$slug = $_GET['slug'] ?? null;
if (!is_string($slug) || $slug === '') {
    header('Location: /blog', true, 302);
    exit;
}

$preview = $site['blog']['preview'];
$repository = new PostRepository(ROOT . '/content/posts', new DateTimeImmutable('today'), $preview);
$post = $repository->find($slug);
if ($post === null) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}
['previous' => $previous, 'next' => $next] = $repository->neighbours($post);

$markdown = new Markdown($_SERVER['HTTP_HOST'] ?? 'localhost');

$view->partial('layout/top', [
    'title' => "{$post->title['en']} - Xalri Blog",
    'active' => 'blog',
    'css' => 'css/blog.css',
    'description' => $post->summary['en'],
]);
?>
    <main class="fade-in">
        <article id="post">
            <a href="/blog" class="back" <?= $view->i18n('blog.back') ?>><?= $view->t('blog.back') ?></a>
            <div class="post-header">
                <h1 <?= View::textAttrs($post->title) ?>><?= View::e($post->title['en']) ?></h1>
<?php $view->partial('blog/meta', ['post' => $post, 'preview' => $preview]); ?>
            </div>
<?php if ($post->cover !== null): ?>
            <img src="<?= View::e($post->cover) ?>" alt="" class="post-cover">
<?php endif; ?>

<?php if ($post->isTranslated()): ?>
<?php foreach (Translator::LANGUAGES as $lang): ?>
            <div class="post-body" lang="<?= $lang ?>" data-lang-block="<?= $lang ?>">
<?= $markdown->toHtml($post->markdown($lang), $lang) ?>
            </div>
<?php endforeach; ?>
<?php else: ?>
<?php $lang = array_key_first($post->body) ?? Translator::DEFAULT; ?>
<?php foreach (array_diff(Translator::LANGUAGES, [$lang]) as $missing): ?>
            <p class="untranslated" data-lang-block="<?= $missing ?>"><?= $view->t('blog.untranslated', $missing) ?></p>
<?php endforeach; ?>
            <div class="post-body" lang="<?= $lang ?>">
<?= $markdown->toHtml($post->markdown($lang), $lang) ?>
            </div>
<?php endif; ?>
        </article>

<?php if ($previous !== null || $next !== null): ?>
        <nav id="post-nav">
<?php if ($previous !== null): ?>
            <a href="<?= View::e($previous->url()) ?>" class="previous" rel="prev">
                <span <?= $view->i18n('blog.previous') ?>><?= $view->t('blog.previous') ?></span>
                <strong <?= View::textAttrs($previous->title) ?>><?= View::e($previous->title['en']) ?></strong>
            </a>
<?php endif; ?>
<?php if ($next !== null): ?>
            <a href="<?= View::e($next->url()) ?>" class="next" rel="next">
                <span <?= $view->i18n('blog.next') ?>><?= $view->t('blog.next') ?></span>
                <strong <?= View::textAttrs($next->title) ?>><?= View::e($next->title['en']) ?></strong>
            </a>
<?php endif; ?>
        </nav>
<?php endif; ?>
    </main>

<?php $view->partial('layout/bottom');
