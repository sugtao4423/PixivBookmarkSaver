<?php

declare(strict_types=1);

require_once __DIR__ . '/../Services/PixivWebService.php';
require_once __DIR__ . '/../Services/FileService.php';

class PixivBookmarkController
{

    public function saveAllBookmarks(string $cookie, string|int $userId): void
    {
        $pixivService = new PixivWebService($cookie);
        $fileService = new FileService($userId);

        $publicBookmarks = $pixivService->getBookmarks($userId, true);
        if ($publicBookmarks === null) {
            echo 'Error: Failed to get public bookmarks.' . PHP_EOL;
            exit(1);
        }

        $privateBookmarks = $pixivService->getBookmarks($userId, false);
        if ($privateBookmarks === null) {
            echo 'Warning: Failed to get private bookmarks.' . PHP_EOL;
            echo 'Warning: It could be another user\'s bookmark.' . PHP_EOL;
            echo PHP_EOL;
        }

        $bookmarks = $privateBookmarks === null ?
            $publicBookmarks :
            array_merge($publicBookmarks, $privateBookmarks);

        $bookmarkCount = count($bookmarks);
        echo "Saving bookmarks... 0 / $bookmarkCount";
        for ($i = 0; $i < $bookmarkCount; $i++) {
            $bookmark = $bookmarks[$i];
            $illust = $pixivService->getIllust($bookmark->getId());
            if ($illust === null) {
                echo 'Error: Failed to get illust.' . PHP_EOL;
                exit(1);
            }

            $thumbnail = $pixivService->getIllustThumbnail($illust);
            if ($thumbnail === null) {
                echo 'Error: Failed to get thumbnail.' . PHP_EOL;
                exit(1);
            }
            $saveResult = $fileService->saveIllustFile($thumbnail);
            if (!$saveResult) {
                echo 'Error: Failed to save thumbnail.' . PHP_EOL;
                exit(1);
            }

            $files = $pixivService->getIllustFiles($illust);
            if ($files === null) {
                echo 'Error: Failed to get illust files.' . PHP_EOL;
                exit(1);
            }
            $saveResult = $fileService->saveIllustFiles($files);
            if (!$saveResult) {
                echo 'Error: Failed to save illust files.' . PHP_EOL;
                exit(1);
            }

            echo "\rSaving bookmarks... " . $i + 1 . " / $bookmarkCount";
        }
        echo PHP_EOL . 'Done!' . PHP_EOL;
    }
}
