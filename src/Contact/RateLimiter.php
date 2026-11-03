<?php

declare(strict_types=1);

namespace Portfolio\Contact;

/**
 * At most $max hits per key in a sliding window, counted in one small file per key. The site runs as a single
 * pod, so the container's temporary directory is enough; it's emptied when the pod restarts.
 */
final class RateLimiter
{
    public function __construct(
        private readonly string $dir,
        private readonly int $max,
        private readonly int $windowSeconds,
    ) {
    }

    /** Counts a hit for the key; false when it's over the limit (that hit isn't counted) */
    public function hit(string $key, ?int $now = null): bool
    {
        $now ??= time();
        if (!is_dir($this->dir)) {
            @mkdir($this->dir, 0700, true);
        }

        $handle = fopen("$this->dir/" . hash('sha256', $key), 'c+');
        if ($handle === false) {
            // Never lose a real message because the counter can't be written
            return true;
        }

        try {
            flock($handle, LOCK_EX);
            $hits = array_filter(
                array_map('intval', explode(',', stream_get_contents($handle) ?: '')),
                fn (int $time): bool => $time > $now - $this->windowSeconds,
            );
            if (count($hits) >= $this->max) {
                return false;
            }

            $hits[] = $now;
            ftruncate($handle, 0);
            rewind($handle);
            fwrite($handle, implode(',', $hits));

            return true;
        } finally {
            flock($handle, LOCK_UN);
            fclose($handle);
        }
    }
}
