<?php

// The RSS feed of the blog: /blog/feed (see .htaccess). In English, like the pages before the switch.

use Portfolio\Content\Markdown;
use Portfolio\Content\PostRepository;

require_once __DIR__ . '/../bootstrap.php';

$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$base = "https://$host";
// Never the drafts, even when previewing them on the pages
$posts = array_slice((new PostRepository(ROOT . '/content/posts', new DateTimeImmutable('today')))->all(), 0, 20);
$markdown = new Markdown($host);

$xml = static fn (string $text): string => htmlspecialchars($text, ENT_XML1 | ENT_QUOTES);

header('Content-Type: application/rss+xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>', "\n";
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:content="http://purl.org/rss/1.0/modules/content/">
    <channel>
        <title>Xalri - Blog</title>
        <link><?= $xml("$base/blog") ?></link>
        <description><?= $xml($translator->text('blog.intro')) ?></description>
        <language>en</language>
        <atom:link href="<?= $xml("$base/blog/feed") ?>" rel="self" type="application/rss+xml"/>
<?php if ($posts !== []): ?>
        <lastBuildDate><?= $posts[0]->date->format(DATE_RSS) ?></lastBuildDate>
<?php endif; ?>
<?php foreach ($posts as $post): ?>
        <item>
            <title><?= $xml($post->title['en']) ?></title>
            <link><?= $xml($base . $post->url()) ?></link>
            <guid isPermaLink="true"><?= $xml($base . $post->url()) ?></guid>
            <pubDate><?= $post->date->format(DATE_RSS) ?></pubDate>
            <description><?= $xml($post->summary['en']) ?></description>
            <content:encoded><?= $xml($markdown->toHtml($post->markdown('en'), 'en')) ?></content:encoded>
<?php foreach ($post->tags as $tag): ?>
            <category><?= $xml($tag) ?></category>
<?php endforeach; ?>
        </item>
<?php endforeach; ?>
    </channel>
</rss>
