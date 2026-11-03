<?php

use Portfolio\Content\ProjectRepository;
use Portfolio\Content\Tag;
use Portfolio\View;

require_once __DIR__ . '/../bootstrap.php';

$projects = (new ProjectRepository(ROOT . '/content/projects'))->all();
$tags = Tag::loadAll(ROOT . '/content/tags.yaml');

$view->partial('layout/top', [
    'title' => 'Xalri - Portfolio',
    'active' => 'projects',
    'css' => 'css/projects.css',
    'favicon' => '/img/logo-background-rounded.png',
]);
?>
    <main class="">
        <h2 class="title" <?= $view->i18n('projects.title') ?>><?= $view->t('projects.title') ?></h2>
        <section id="search">
            <input type="text" placeholder="Search for a project" id="search-input" class="animate from-left">
            <div class="search-tags-container animate from-right">
                <label class="search-tags-label">
                    <p>Type</p>
                    <img class="arrow" src="/img/small_arrow.svg" alt="">
                </label>
                <div class="search-tags animate from-bottom">
<?php foreach ($tags as $tag): ?>
                    <label class="tag"><?php if ($tag->icon !== null): ?><img src="<?= View::e($tag->icon) ?>" alt=""><?php endif; ?><?= View::e($tag->name) ?></label>
<?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="project-list">
            <div id="list">
<?php foreach ($projects as $project): ?>
                <a href="<?= View::e($project->url()) ?>" class="project-card animate from-bottom" data-tags="<?= View::e(implode(',', $project->types())) ?>">
                    <img src="<?= $project->image() ?>" alt="<?= View::e($project->name) ?>" class="project-image">
                    <div class="infos">
                        <h3><?= View::e($project->name) ?></h3>
                        <p class="description" <?= View::textAttrs($project->summary) ?>><?= View::e($project->summary['en']) ?></p>
                    </div>
                </a>
<?php endforeach; ?>
            </div>
        </section>
    </main>

<?php $view->partial('layout/bottom', ['scripts' => ['js/projects.js']]);
