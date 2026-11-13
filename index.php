<?php

/**
 * Tasker (IT0049 TSA3) — Root Entry Point for Shared Hosting.
 *
 * When document root points to /htdocs (such as InfinityFree), this forwards
 * incoming requests cleanly into Laravel's public/index.php bootstrapper.
 */

if (file_exists(__DIR__ . '/public/index.php')) {
    require_once __DIR__ . '/public/index.php';
} else {
    define('LARAVEL_START', microtime(true));

    if (file_exists($maintenance = __DIR__ . '/storage/framework/maintenance.php')) {
        require $maintenance;
    }

    require __DIR__ . '/vendor/autoload.php';

    /** @var \Illuminate\Foundation\Application $app */
    $app = require_once __DIR__ . '/bootstrap/app.php';

    $app->handleRequest(\Illuminate\Http\Request::capture());
}
