<?php

declare(strict_types=1);

namespace Portfolio\Content;

/** One project, from content/projects/<codeName>.yaml */
final readonly class Project
{
    /**
     * @param list<string>          $languages
     * @param list<string>          $tags
     * @param array<string, string> $summary     Short text of the cards, by language
     * @param array<string, string> $description Long text of the project page, by language
     */
    public function __construct(
        public string $codeName,
        public string $name,
        public int $order,
        public ?string $date,
        public array $languages,
        public array $tags,
        public array $summary,
        public array $description,
        public ?string $github,
        public ?string $live,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(string $codeName, array $data): self
    {
        return new self(
            codeName: $codeName,
            name: $data['name'],
            order: $data['order'] ?? 0,
            date: isset($data['date']) ? (string) $data['date'] : null,
            languages: $data['languages'] ?? [],
            tags: $data['tags'] ?? [],
            summary: $data['summary'],
            description: $data['description'],
            github: $data['github'] ?? null,
            live: $data['live'] ?? null,
        );
    }

    /** The languages then the tags, each once: what the /projects filters match */
    public function types(): array
    {
        return array_values(array_unique([...$this->languages, ...$this->tags]));
    }

    public function url(): string
    {
        return '/project?project=' . rawurlencode($this->codeName);
    }

    public function image(): string
    {
        return "/img/projects/$this->codeName.webp";
    }
}
