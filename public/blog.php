<?php

// The list of posts, newest first: /blog, /blog?tag=<tag>, /blog?page=<n>

use Portfolio\Content\PostRepository;
use Portfolio\View;

require_once __DIR__ . '/../bootstrap.php';

$preview = $site['blog']['preview'];
$repository = new PostRepository(ROOT . '/content/posts', new DateTimeImmutable('today'), $preview);

$tag = $_GET['tag'] ?? null;
$tag = is_string($tag) && $tag !== '' ? $tag : null;
$posts = $tag === null ? $repository->all() : $repository->tagged($tag);
$tags = $repository->tags();

$perPage = $site['blog']['per_page'];
$pages = max(1, (int) ceil(count($posts) / $perPage));
$page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: 1;
if ($page > $pages) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}
$posts = array_slice($posts, ($page - 1) * $perPage, $perPage);

/** The URL of a page of the list, keeping the tag */
$pageUrl = static function (int $n) use ($tag): string {
    $query = http_build_query(array_filter(['tag' => $tag, 'page' => $n > 1 ? $n : null]));

    return $query === '' ? '/blog' : "/blog?$query";
};

$view->partial('layout/top', [
    'title' => 'Blog - Xalri Portfolio',
    'active' => 'blog',
    'css' => 'css/blog.css',
]);
?>
    <main class="fade-in">
        <section id="blog-header">
            <h2 class="title" <?= $view->i18n('blog.title') ?>><?= $view->t('blog.title') ?></h2>
            <p class="intro" <?= $view->i18n('blog.intro') ?>><?= $view->t('blog.intro') ?></p>
<?php if ($tags !== []): ?>
            <nav class="tag-filter" aria-label="Tags">
                <a href="/blog"<?= $tag === null ? ' class="selected"' : '' ?> <?= $view->i18n('blog.all') ?>><?= $view->t('blog.all') ?></a>
<?php foreach ($tags as $name): ?>
                <a href="/blog?tag=<?= View::e(rawurlencode($name)) ?>"<?= $name === $tag ? ' class="selected"' : '' ?>>#<?= View::e($name) ?></a>
<?php endforeach; ?>
            </nav>
<?php endif; ?>
        </section>

<?php if ($posts === []): ?>
        <section id="blog-empty">
<?php if ($tag === null): ?>
            <h3 <?= $view->i18n('blog.empty.title') ?>><?= $view->t('blog.empty.title') ?></h3>
            <p <?= $view->i18n('blog.empty.text') ?>><?= $view->t('blog.empty.text') ?></p>
            <a href="/" class="button" <?= $view->i18n('back_home') ?>><?= $view->t('back_home') ?></a>
<?php else: ?>
            <p <?= $view->i18n('blog.empty.tag') ?>><?= $view->t('blog.empty.tag') ?></p>
            <a href="/blog" class="button" <?= $view->i18n('blog.back') ?>><?= $view->t('blog.back') ?></a>
<?php endif; ?>
        </section>
<?php else: ?>
        <section id="post-list">
<?php foreach ($posts as $post): ?>
            <article class="post-card animate from-bottom">
<?php if ($post->cover !== null): ?>
                <img src="<?= View::e($post->cover) ?>" alt="" class="post-cover">
<?php endif; ?>
                <div class="post-card-body">
                    <h3><a href="<?= View::e($post->url()) ?>" <?= View::textAttrs($post->title) ?>><?= View::e($post->title['en']) ?></a></h3>
<?php $view->partial('blog/meta', ['post' => $post, 'preview' => $preview]); ?>
                    <p class="summary" <?= View::textAttrs($post->summary) ?>><?= View::e($post->summary['en']) ?></p>
                </div>
            </article>
<?php endforeach; ?>
        </section>

<?php if ($pages > 1): ?>
        <nav id="pagination" aria-label="Pagination">
<?php if ($page > 1): ?>
            <a href="<?= View::e($pageUrl($page - 1)) ?>" rel="prev" <?= $view->i18n('blog.newer') ?>><?= $view->t('blog.newer') ?></a>
<?php endif; ?>
            <span><span <?= $view->i18n('blog.page') ?>><?= $view->t('blog.page') ?></span> <?= $page ?> / <?= $pages ?></span>
<?php if ($page < $pages): ?>
            <a href="<?= View::e($pageUrl($page + 1)) ?>" rel="next" <?= $view->i18n('blog.older') ?>><?= $view->t('blog.older') ?></a>
<?php endif; ?>
        </nav>
<?php endif; ?>
<?php endif; ?>

        <a href="/blog/feed" class="feed-link" <?= $view->i18n('blog.feed') ?>><?= $view->t('blog.feed') ?></a>
    </main>

<?php $view->partial('layout/bottom');
