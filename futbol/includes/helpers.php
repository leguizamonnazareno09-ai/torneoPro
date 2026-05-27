<?php
declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function active(string $page, string $current): string
{
    return $page === $current ? ' active' : '';
}
