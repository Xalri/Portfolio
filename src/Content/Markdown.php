<?php

declare(strict_types=1);

namespace Portfolio\Content;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\MarkdownConverter;

/**
 * The HTML of a post's Markdown: GitHub-flavoured (tables, task lists, strikethrough, autolinks), with an anchor on
 * each heading and outside links opening in a new tab. Both languages of a post are on its page, so heading ids
 * start with the language (#en-setup, #fr-installation). The posts come from the repository, so their raw HTML is
 * kept (for a <figure> or a <video>), but javascript: links are not.
 */
final class Markdown
{
    /** @var array<string, MarkdownConverter> By language */
    private array $converters = [];

    public function __construct(private readonly string $host)
    {
    }

    public function toHtml(string $markdown, string $lang): string
    {
        $this->converters[$lang] ??= $this->converter($lang);

        return $this->converters[$lang]->convert($markdown)->getContent();
    }

    private function converter(string $lang): MarkdownConverter
    {
        $environment = new Environment([
            'html_input' => 'allow',
            'allow_unsafe_links' => false,
            'heading_permalink' => [
                'symbol' => '#',
                'insert' => 'after',
                'id_prefix' => $lang,
                'fragment_prefix' => $lang,
                'apply_id_to_heading' => true,
                'title' => '',
                'aria_hidden' => true,
            ],
            'external_link' => [
                'internal_hosts' => [$this->host],
                'open_in_new_window' => true,
                'nofollow' => '',
                'noopener' => 'external',
                'noreferrer' => 'external',
            ],
        ]);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());
        $environment->addExtension(new HeadingPermalinkExtension());
        $environment->addExtension(new ExternalLinkExtension());

        return new MarkdownConverter($environment);
    }
}
