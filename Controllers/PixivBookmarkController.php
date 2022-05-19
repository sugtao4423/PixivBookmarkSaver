<?php

declare(strict_types=1);

require_once __DIR__ . '/../Services/PixivWebService.php';

class PixivBookmarkController
{

    public function saveAllBookmarks(string $cookie, string|int $userId): void
    {
        $service = new PixivWebService($cookie);

        $bookmarks = $service->getBookmarks($userId);
        if ($bookmarks === null) {
            echo 'Error: Failed to get bookmarks.' . PHP_EOL;
            exit(1);
        }

        $illustSaveDir = __DIR__ . '/../bookmarks-' . $userId;
        @mkdir($illustSaveDir);

        $bookmarkCount = count($bookmarks);
        echo "Saving bookmarks... 0 / $bookmarkCount";
        for ($i = 0; $i < $bookmarkCount; $i++) {
            $bookmark = $bookmarks[$i];
            $illust = $service->getIllustDetail($bookmark->getId());
            if ($illust === null) {
                echo 'Error: Failed to get illust detail.' . PHP_EOL;
                exit(1);
            }

            $files = $service->getIllustFiles($illust);
            if ($files === null) {
                echo 'Error: Failed to get illust files.' . PHP_EOL;
                exit(1);
            }

            foreach ($files as $file) {
                $filePath = $illustSaveDir . '/' . $file->getFileName();
                file_put_contents($filePath, $file->getFileContent());
            }

            echo "\rSaving bookmarks... " . $i + 1 . " / $bookmarkCount";
        }
        echo PHP_EOL . 'Done!' . PHP_EOL;
    }
}
