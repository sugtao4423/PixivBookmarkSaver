<?php

declare(strict_types=1);

require_once __DIR__ . '/Controllers/PixivBookmarkController.php';

(new PixivBookmarkController())->saveAllBookmarks($cookie, $userId);
