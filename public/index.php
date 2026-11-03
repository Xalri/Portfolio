<?php

use Portfolio\Content\ProjectRepository;
use Portfolio\View;

require_once __DIR__ . '/../bootstrap.php';

$projects = (new ProjectRepository(ROOT . '/content/projects'))->all();
$skills = ['html5', 'css3', 'JS', 'Python', 'PHP'];
// Out of 10
$tools = ['git' => 3, 'github' => 5];

$view->partial('layout/top', [
    'title' => 'Xalri - Portfolio',
    'active' => 'home',
    'css' => 'css/index.css',
    'favicon' => '/img/logo-background-rounded.png',
]);
?>
    <main class="fade-in">
        <section id="about">
            <div class="text">
               <h3 class="animate" <?= $view->i18n('home.i_am') ?>><?= $view->t('home.i_am') ?></h3>
               <h1 class="animate" >Samy .</h1>
               <p class="animate" <?= $view->i18n('home.intro') ?>><?= $view->t('home.intro') ?></p>
               <div class="clear-infos animate">
                    <div class="element">
                        <img src="/img/map-pin.svg" alt="">
                        <p>France - Paris</p>
                    </div>
               </div>
            </div>
            <img class="animate me" src="/img/me.webp" alt="">
        </section>

        <section id="skills">
            <h3 class="animate" <?= $view->i18n('home.skills') ?>><?= $view->t('home.skills') ?></h3>
            <div class="carousel animate">
<?php foreach (['', ' aria-hidden'] as $hidden): ?>
                <div<?= $hidden ?> class="group">
<?php foreach ($skills as $skill): ?>
                    <img src="/img/languages/<?= $skill ?>.svg" alt="">
<?php endforeach; ?>
                </div>
<?php endforeach; ?>
            </div>
            <div class="progress-bar">
<?php foreach ($tools as $tool => $level): ?>
                <div class="element animate from-bottom">
                    <img src="/img/languages/<?= $tool ?>.svg" alt="">
                    <div class="element-progress-bar">
<?php for ($dot = 1; $dot <= 10; $dot++): ?>
                        <div class="dot<?= $dot <= $level ? ' ok' : '' ?>"></div>
<?php endfor; ?>
                    </div>
                </div>
<?php endforeach; ?>
            </div>
        </section>

        <section id="projects">
            <h2 class="animate from-left">Projects</h2>
            <div class="projects-container">
<?php foreach ($projects as $project): ?>
                <a href="<?= View::e($project->url()) ?>" class="project-card animate from-bottom">
                    <img src="<?= $project->image() ?>" alt="<?= View::e($project->name) ?>" class="project-image">

                    <div class="infos">
                        <h3><?= View::e($project->name) ?></h3>
                        <div class="tags">
<?php foreach ($project->types() as $type): ?>
                            <span class="tag"><?= View::e($type) ?></span>
<?php endforeach; ?>
                        </div>
                    </div>
                </a>
<?php endforeach; ?>
            </div>
        </section>
    </main>

<?php $view->partial('layout/bottom', ['scripts' => ['js/index.js']]);
