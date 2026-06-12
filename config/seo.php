<?php

return [
    'site_name' => env('SEO_SITE_NAME', 'Carlos Codex'),
    'default_title' => env('SEO_DEFAULT_TITLE', 'Carlos Codex | Desarrollo web y aplicaciones'),
    'default_description' => env(
        'SEO_DEFAULT_DESCRIPTION',
        'Desarrollo de aplicaciones, webs y soluciones digitales a medida para particulares y empresas.'
    ),
    'default_image' => env('SEO_DEFAULT_IMAGE', 'img/og-default.jpg'),
    'twitter_handle' => env('SEO_TWITTER_HANDLE'),
    'locale' => 'es_ES',

    'person' => [
        'name' => env('SEO_PERSON_NAME', 'Carlos Burgos Távora'),
        'job_title' => env('SEO_PERSON_JOB_TITLE', 'Desarrollador Full Stack'),
        'email' => env('APP_CONTACT_EMAIL'),
        'linkedin' => env('SEO_LINKEDIN_URL'),
        'github' => env('SEO_GITHUB_URL'),
    ],
];
