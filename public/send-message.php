<?php

// The contact form's endpoint (POST /send-message, called by js/contact.js): answers {status, message} in JSON.

use Portfolio\Contact\ContactMailer;
use Portfolio\Contact\ContactMessage;
use Portfolio\Contact\InvalidMessage;
use Portfolio\Contact\RateLimiter;

require_once __DIR__ . '/../bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

function respond(int $code, string $status, string $message): never
{
    http_response_code($code);
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(405, 'error', 'Invalid request method: ' . $_SERVER['REQUEST_METHOD']);
}

// Only from the site's own form: browsers always send Origin with a cross-site POST. The host the visitor used
// is Host, or X-Forwarded-Host when the reverse proxy in front rewrites it.
$origin = $_SERVER['HTTP_ORIGIN'] ?? null;
if ($origin !== null) {
    $hosts = array_map(
        static fn (string $host): ?string => parse_url('//' . trim($host), PHP_URL_HOST),
        explode(',', ($_SERVER['HTTP_HOST'] ?? '') . ',' . ($_SERVER['HTTP_X_FORWARDED_HOST'] ?? '')),
    );
    if (!in_array(parse_url($origin, PHP_URL_HOST), array_filter($hosts), true)) {
        respond(403, 'error', 'Invalid request origin.');
    }
}

// A filled trap field is a bot: let it believe it worked
if (($_POST['website'] ?? '') !== '') {
    respond(200, 'success', 'Your message has been sent successfully.');
}

try {
    $message = ContactMessage::fromPost($_POST);
} catch (InvalidMessage $e) {
    respond(422, 'error', $e->getMessage());
}

$contact = $site['contact'];

// Behind Cloudflare, REMOTE_ADDR is the proxy's
$ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$limiter = new RateLimiter(sys_get_temp_dir() . '/contact-rate-limit', $contact['max_messages'], $contact['window_seconds']);
if (!$limiter->hit($ip)) {
    respond(429, 'error', 'Too many messages, please try again later.');
}

if ($contact['dsn'] === null) {
    error_log('Contact form: MAILER_DSN is not set, message not sent');
    respond(503, 'error', 'Failed to send your message. Please try again later.');
}

try {
    (new ContactMailer($contact['dsn'], $contact['from'], $contact['to']))->send($message);
} catch (Throwable $e) {
    error_log('Contact form: sending failed: ' . $e->getMessage());
    respond(502, 'error', 'Failed to send your message. Please try again later.');
}

respond(200, 'success', 'Your message has been sent successfully.');
