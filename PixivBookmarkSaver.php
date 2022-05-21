<?php

declare(strict_types=1);

require_once __DIR__ . '/Controllers/PixivBookmarkController.php';

$opts = getopt('c:u:', ['cookie:', 'userId:']);
$cookie = $opts['c'] ?? @$opts['cookie'];
$userId = $opts['u'] ?? @$opts['userId'];

if (!isset($cookie) || !isset($userId)) {
    echo 'Usage: php PixivBookmarkSaver.php --cookie=<cookie> --userId=<userId>' . PHP_EOL;
    exit(1);
}

(new PixivBookmarkController())->saveAllBookmarks($cookie, $userId);
