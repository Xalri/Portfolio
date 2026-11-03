<?php

// Loaded first by every page in public/: autoloading, settings, and the helpers the templates use.

declare(strict_types=1);

use Portfolio\I18n\Translator;
use Portfolio\Person;
use Portfolio\View;

require __DIR__ . '/vendor/autoload.php';

const ROOT = __DIR__;

$site = require ROOT . '/config/site.php';

$translator = new Translator(ROOT . '/lang', [
    'age' => Person::ageOn($site['birthdate'], new DateTimeImmutable('today')),
]);

$view = new View(ROOT . '/templates', ROOT . '/public', $translator, $site);
