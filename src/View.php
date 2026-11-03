<?php

declare(strict_types=1);

namespace Portfolio;

use Portfolio\I18n\Translator;

/** What the pages and templates/ use to print things */
final class View
{
    /** @var array<string, string> */
    private array $versions = [];

    /** @param array<string, mixed> $site */
    public function __construct(
        private readonly string $templates,
        private readonly string $public,
        private readonly Translator $translator,
        public readonly array $site,
    ) {
    }

    /** Prints templates/<name>.php with $vars, $view and $site in scope */
    public function partial(string $name, array $vars = []): void
    {
        $view = $this;
        $site = $this->site;
        extract($vars, EXTR_SKIP);
        require "$this->templates/$name.php";
    }

    public static function e(string $text): string
    {
        return htmlspecialchars($text, ENT_QUOTES);
    }

    /** A file of public/ with its content hash, so browsers can cache it until it changes */
    public function asset(string $path): string
    {
        $path = '/' . ltrim($path, '/');
        $this->versions[$path] ??= substr(md5_file($this->public . $path) ?: '', 0, 8);

        return "$path?v={$this->versions[$path]}";
    }

    /** An interface string, in English unless asked otherwise, for the element's content */
    public function t(string $key, string $lang = Translator::DEFAULT): string
    {
        return $this->translator->text($key, $lang);
    }

    /** The data-fr / data-en attributes of an interface string */
    public function i18n(string $key): string
    {
        return $this->translator->attrs($key);
    }

    /**
     * data-fr / data-en attributes for plain text (project content). script.js puts them in innerHTML, so the
     * text is escaped once for HTML and once more for the attribute.
     *
     * @param array<string, string> $byLanguage
     */
    public static function textAttrs(array $byLanguage): string
    {
        $attrs = [];
        foreach (Translator::LANGUAGES as $lang) {
            $attrs[] = sprintf('data-%s="%s"', $lang, self::e(self::e($byLanguage[$lang] ?? '')));
        }

        return implode(' ', $attrs);
    }
}
