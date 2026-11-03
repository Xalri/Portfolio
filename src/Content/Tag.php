<?php

declare(strict_types=1);

namespace Portfolio\Content;

use Symfony\Component\Yaml\Yaml;

/** A filter of /projects, from content/tags.yaml */
final readonly class Tag
{
    public function __construct(public string $name, public ?string $icon)
    {
    }

    /** @return list<self> */
    public static function loadAll(string $file): array
    {
        return array_map(
            static fn (array $tag): self => new self($tag['name'], $tag['icon'] ?? null),
            Yaml::parseFile($file),
        );
    }
}
