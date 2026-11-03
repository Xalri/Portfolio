<?php

declare(strict_types=1);

namespace Portfolio\Content;

use DateTimeImmutable;
use Portfolio\I18n\Translator;
use Symfony\Component\Yaml\Yaml;

/**
 * The posts of content/posts/, one folder each, newest first. Folders starting with _ are skipped (the example).
 * Drafts and posts dated in the future are hidden, unless $showUnpublished (to preview them locally).
 */
final class PostRepository
{
    /** @var array<string, Post>|null By slug */
    private ?array $posts = null;

    public function __construct(
        private readonly string $dir,
        private readonly DateTimeImmutable $today,
        private readonly bool $showUnpublished = false,
    ) {
    }

    /** @return list<Post> */
    public function all(): array
    {
        return array_values($this->load());
    }

    /** @return list<Post> The posts with the tag */
    public function tagged(string $tag): array
    {
        return array_values(array_filter($this->load(), static fn (Post $post): bool => in_array($tag, $post->tags, true)));
    }

    /** @return list<string> Every tag, the most used first */
    public function tags(): array
    {
        $counts = [];
        foreach ($this->load() as $post) {
            foreach ($post->tags as $tag) {
                $counts[$tag] = ($counts[$tag] ?? 0) + 1;
            }
        }
        arsort($counts);

        return array_map('strval', array_keys($counts));
    }

    public function find(string $slug): ?Post
    {
        return $this->load()[$slug] ?? null;
    }

    /** @return array{previous: ?Post, next: ?Post} The older and the newer post */
    public function neighbours(Post $post): array
    {
        $posts = $this->all();
        $i = array_search($post, $posts, true);

        return [
            'previous' => $posts[$i + 1] ?? null,
            'next' => $i > 0 ? $posts[$i - 1] : null,
        ];
    }

    /** @return array<string, Post> */
    private function load(): array
    {
        if ($this->posts !== null) {
            return $this->posts;
        }

        $posts = [];
        foreach (glob("$this->dir/*/post.yaml") ?: [] as $file) {
            $folder = dirname($file);
            $slug = basename($folder);
            if (str_starts_with($slug, '_')) {
                continue;
            }

            $body = [];
            foreach (Translator::LANGUAGES as $lang) {
                if (is_file("$folder/$lang.md")) {
                    $body[$lang] = (string) file_get_contents("$folder/$lang.md");
                }
            }

            $post = Post::fromArray($slug, Yaml::parseFile($file), $body);
            if ($this->showUnpublished || $post->isPublishedOn($this->today)) {
                $posts[$slug] = $post;
            }
        }
        uasort($posts, static fn (Post $a, Post $b): int => [$b->date, $b->slug] <=> [$a->date, $a->slug]);

        return $this->posts = $posts;
    }
}
