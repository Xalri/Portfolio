<?php

declare(strict_types=1);

namespace Portfolio\I18n;

use OutOfBoundsException;

/**
 * The interface strings, from lang/<lang>.php. Pages are rendered in English and script.js swaps each element's
 * content for its data-fr / data-en attribute, so a string is printed once as text and once as both attributes.
 * Strings are trusted HTML (some hold a flag image); {name} placeholders are filled from $vars.
 */
final class Translator
{
    public const LANGUAGES = ['fr', 'en'];
    public const DEFAULT = 'en';

    /** @var array<string, array<string, string>> */
    private array $strings = [];

    /** @param array<string, string|int> $vars */
    public function __construct(string $dir, private readonly array $vars = [])
    {
        foreach (self::LANGUAGES as $lang) {
            $this->strings[$lang] = require "$dir/$lang.php";
        }
    }

    public function text(string $key, string $lang = self::DEFAULT): string
    {
        $string = $this->strings[$lang][$key]
            ?? throw new OutOfBoundsException("No '$lang' string for '$key'");

        return strtr($string, array_combine(
            array_map(static fn (string $name): string => '{' . $name . '}', array_keys($this->vars)),
            array_map('strval', $this->vars),
        ));
    }

    /** data-fr="…" data-en="…" for the string */
    public function attrs(string $key): string
    {
        $attrs = [];
        foreach (self::LANGUAGES as $lang) {
            $attrs[] = sprintf('data-%s="%s"', $lang, htmlspecialchars($this->text($key, $lang), ENT_QUOTES));
        }

        return implode(' ', $attrs);
    }
}
