<?php

use Portfolio\Content\ProjectRepository;
use Portfolio\View;

require_once __DIR__ . '/../bootstrap.php';

$codeName = $_GET['project'] ?? null;
if (!is_string($codeName) || $codeName === '') {
    header('Location: /projects', true, 302);
    exit;
}

$project = (new ProjectRepository(ROOT . '/content/projects'))->find($codeName);
if ($project === null) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$view->partial('layout/top', [
    'title' => "$project->name - Xalri Portfolio",
    'active' => 'projects',
    'css' => 'css/project.css',
]);
?>
    <main class="fade-in">
        <section id="project-details">
            <div class="project-header">
                <h1><?= View::e($project->name) ?></h1>
                <p class="description" <?= View::textAttrs($project->summary) ?>><?= View::e($project->summary['en']) ?></p>
            </div>
            <div class="project-image">
                <img src="<?= $project->image() ?>" alt="<?= View::e($project->name) ?>">
            </div>
        </section>

        <section id="project-info">
            <h2 <?= $view->i18n('project.details') ?>><?= $view->t('project.details') ?></h2>
            <ul>
                <li><strong <?= $view->i18n('project.languages') ?>><?= $view->t('project.languages') ?></strong> <?= View::e(implode(', ', $project->languages)) ?></li>
<?php if ($project->date !== null): ?>
                <li><strong <?= $view->i18n('project.date') ?>><?= $view->t('project.date') ?></strong> <?= View::e($project->date) ?></li>
<?php endif; ?>
                <li><strong <?= $view->i18n('project.technologies') ?>><?= $view->t('project.technologies') ?></strong> <?= View::e(implode(', ', $project->tags)) ?></li>
            </ul>
        </section>

        <section id="project-content">
            <h2 <?= $view->i18n('project.description') ?>><?= $view->t('project.description') ?></h2>
            <p <?= View::textAttrs($project->description) ?>><?= View::e($project->description['en']) ?></p>
        </section>

        <section id="project-links">
            <h2 <?= $view->i18n('project.links') ?>><?= $view->t('project.links') ?></h2>
            <ul>
<?php if ($project->github !== null): ?>
                <li><a href="<?= View::e($project->github) ?>" target="_blank" <?= $view->i18n('project.source') ?>><?= $view->t('project.source') ?></a></li>
<?php endif; ?>
<?php if ($project->live !== null): ?>
                <li><a href="<?= View::e($project->live) ?>" target="_blank" <?= $view->i18n('project.live') ?>><?= $view->t('project.live') ?></a></li>
<?php endif; ?>
            </ul>
        </section>
    </main>

<?php $view->partial('layout/bottom');
