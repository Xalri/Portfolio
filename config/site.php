<?php

// Settings shared by every page. Secrets (the SMTP password) are never here: they come from the environment,
// which on k3s is the namespace's secret website-env.
return [
    // The age shown on the site is counted from this date
    'birthdate' => '2008-11-27',

    'analytics' => [
        'umami_src' => 'https://unami.xalri.ovh/script.js',
        'umami_website_id' => '2122e7f9-a7d3-4602-8e26-b7451721f6ae',
        'google_tag' => 'G-N5G8BQ48XX',
    ],

    'blog' => [
        // BLOG_PREVIEW=1 also lists the drafts and the posts dated in the future, to read them before they are out
        'preview' => getenv('BLOG_PREVIEW') === '1',
        'per_page' => 10,
    ],

    'contact' => [
        // smtp://user:pass@host:port, e.g. the cluster's mailserver on its submission port
        'dsn' => getenv('MAILER_DSN') ?: null,
        'from' => getenv('MAIL_FROM') ?: 'contact@xalri.fr',
        'to' => getenv('MAIL_TO') ?: 'samy@teilloux.com',
        // Per visitor IP
        'max_messages' => 5,
        'window_seconds' => 3600,
    ],
];
