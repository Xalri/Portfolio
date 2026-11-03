<?php

declare(strict_types=1);

namespace Portfolio\Content;

use DateTimeImmutable;
use Portfolio\I18n\Translator;

/**
 * One blog post, from content/posts/<slug>/: post.yaml for what the lists show, and the text in Markdown, one
 * file per language (en.md, fr.md). A language without its file falls back to the other one.
 */
final readonly class Post
{
    private const WORDS_PER_MINUTE = 200;

    private const MONTHS = [
        'en' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
            'November', 'December'],
        'fr' => ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre',
            'novembre', 'décembre'],
    ];

    /**
     * @param array<string, string> $title   By language
     * @param array<string, string> $summary By language
     * @param list<string>          $tags
     * @param array<string, string> $body    The Markdown of each language that has its file
     */
    public function __construct(
        public string $slug,
        public array $title,
        public array $summary,
        public DateTimeImmutable $date,
        public array $tags,
        public bool $draft,
        public ?string $cover,
        public array $body,
    ) {
    }

    /**
     * @param array<string, mixed>  $data post.yaml
     * @param array<string, string> $body
     */
    public static function fromArray(string $slug, array $data, array $body): self
    {
        return new self(
            slug: $slug,
            title: self::byLanguage($data['title']),
            summary: self::byLanguage($data['summary'] ?? ''),
            // YAML reads an unquoted 2026-11-03 as a timestamp
            date: is_int($data['date'])
                ? (new DateTimeImmutable())->setTimestamp($data['date'])->setTime(0, 0)
                : new DateTimeImmutable((string) $data['date']),
            tags: $data['tags'] ?? [],
            draft: $data['draft'] ?? false,
            cover: $data['cover'] ?? null,
            body: $body,
        );
    }

    /** Whether the public sees it: not a draft, and not dated in the future (posts can be scheduled) */
    public function isPublishedOn(DateTimeImmutable $today): bool
    {
        return !$this->draft && $this->date <= $today;
    }

    public function url(): string
    {
        return '/blog/' . rawurlencode($this->slug);
    }

    /** @return array<string, string> "3 November 2026", "3 novembre 2026" */
    public function formattedDate(): array
    {
        $dates = [];
        foreach (Translator::LANGUAGES as $lang) {
            $month = self::MONTHS[$lang][(int) $this->date->format('n') - 1];
            $dates[$lang] = $this->date->format('j') . " $month " . $this->date->format('Y');
        }

        return $dates;
    }

    /** @return array<string, int> Minutes, at least 1, by language */
    public function readingMinutes(): array
    {
        $minutes = [];
        foreach (Translator::LANGUAGES as $lang) {
            $words = str_word_count(strip_tags($this->markdown($lang)));
            $minutes[$lang] = max(1, (int) round($words / self::WORDS_PER_MINUTE));
        }

        return $minutes;
    }

    /** The Markdown of the language, or of the other one when it has no file */
    public function markdown(string $lang): string
    {
        return $this->body[$lang] ?? array_values($this->body)[0] ?? '';
    }

    /** Whether each language has its own text, rather than one shown for both */
    public function isTranslated(): bool
    {
        return count($this->body) === count(Translator::LANGUAGES);
    }

    /**
     * A plain string is the same in every language
     *
     * @param string|array<string, string> $value
     *
     * @return array<string, string>
     */
    private static function byLanguage(string|array $value): array
    {
        if (is_string($value)) {
            return array_fill_keys(Translator::LANGUAGES, $value);
        }

        $first = reset($value) ?: '';
        $texts = [];
        foreach (Translator::LANGUAGES as $lang) {
            $texts[$lang] = $value[$lang] ?? $first;
        }

        return $texts;
    }
}
