<?php

declare(strict_types=1);

namespace Portfolio\Content;

use Symfony\Component\Yaml\Yaml;

/** The projects of content/projects/, one YAML file each, sorted by their order field */
final class ProjectRepository
{
    /** @var array<string, Project>|null By code name */
    private ?array $projects = null;

    public function __construct(private readonly string $dir)
    {
    }

    /** @return list<Project> */
    public function all(): array
    {
        return array_values($this->load());
    }

    public function find(string $codeName): ?Project
    {
        return $this->load()[$codeName] ?? null;
    }

    /** @return array<string, Project> */
    private function load(): array
    {
        if ($this->projects !== null) {
            return $this->projects;
        }

        $projects = [];
        foreach (glob("$this->dir/*.yaml") ?: [] as $file) {
            $codeName = basename($file, '.yaml');
            $projects[$codeName] = Project::fromArray($codeName, Yaml::parseFile($file));
        }
        uasort($projects, static fn (Project $a, Project $b): int => $a->order <=> $b->order);

        return $this->projects = $projects;
    }
}
