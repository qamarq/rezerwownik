<?php

declare(strict_types=1);

function url(string $path = ''): string
{
    return APP_BASE . '/' . ltrim($path, '/');
}

function redirect(string $path): never
{
    header('Location: ' . url($path));
    exit;
}
