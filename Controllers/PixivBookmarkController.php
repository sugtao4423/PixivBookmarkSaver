<?php

declare(strict_types=1);

require_once __DIR__ . '/../Services/PixivWebService.php';

class PixivBookmarkController
{

    public function saveAllBookmarks(string $cookie, string|int $userId): void
    {
        $service = new PixivWebService($cookie);

        $publicBookmarks = $service->getBookmarks($userId, true);
        if ($publicBookmarks === null) {
            echo 'Error: Failed to get public bookmarks.' . PHP_EOL;
            exit(1);
        }

        $privateBookmarks = $service->getBookmarks($userId, false);
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
            $illust = $service->getIllust($bookmark->getId());
            if ($illust === null) {
                echo 'Error: Failed to get illust.' . PHP_EOL;
                exit(1);
            }

            $thumbnail = $service->getIllustThumbnail($illust);
            if ($thumbnail === null) {
                echo 'Error: Failed to get thumbnail.' . PHP_EOL;
                exit(1);
            }
            $this->saveIllustFiles($userId, [$thumbnail]);

            $files = $service->getIllustFiles($illust);
            if ($files === null) {
                echo 'Error: Failed to get illust files.' . PHP_EOL;
                exit(1);
            }
            $this->saveIllustFiles($userId, $files);

            echo "\rSaving bookmarks... " . $i + 1 . " / $bookmarkCount";
        }
        echo PHP_EOL . 'Done!' . PHP_EOL;
    }

    private function saveIllustFiles(string|int $userId, array $illustFiles): void
    {
        $illustSaveDir = __DIR__ . '/../bookmarks-' . $userId;
        if (!file_exists($illustSaveDir)) {
            mkdir($illustSaveDir);
        }
        foreach ($illustFiles as $file) {
            $filePath = $illustSaveDir . '/' . $file->getFileName();
            file_put_contents($filePath, $file->getFileContent());
        }
    }
}
