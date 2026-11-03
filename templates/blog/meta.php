<?php
/**
 * The date, reading time and tags of a post, on the cards of /blog and on the post's page: $post, $preview
 * (whether drafts and scheduled posts are listed, so they get a badge).
 *
 * @var Portfolio\View $view
 * @var Portfolio\Content\Post $post
 * @var bool $preview
 */

use Portfolio\View;

$minutes = $post->readingMinutes();
$reading = [];
foreach ($minutes as $lang => $count) {
    $reading[$lang] = "$count " . $view->t('blog.min_read', $lang);
}
?>
<div class="post-meta">
    <time datetime="<?= $post->date->format('Y-m-d') ?>" <?= View::textAttrs($post->formattedDate()) ?>><?= View::e($post->formattedDate()['en']) ?></time>
    <span class="dot">·</span>
    <span <?= View::textAttrs($reading) ?>><?= View::e($reading['en']) ?></span>
<?php if ($preview && $post->draft): ?>
    <span class="badge" <?= $view->i18n('blog.draft') ?>><?= $view->t('blog.draft') ?></span>
<?php elseif ($preview && $post->date > new DateTimeImmutable('today')): ?>
    <span class="badge" <?= $view->i18n('blog.scheduled') ?>><?= $view->t('blog.scheduled') ?></span>
<?php endif; ?>
</div>
<?php if ($post->tags !== []): ?>
<ul class="post-tags">
<?php foreach ($post->tags as $tag): ?>
    <li><a href="/blog?tag=<?= View::e(rawurlencode($tag)) ?>">#<?= View::e($tag) ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
