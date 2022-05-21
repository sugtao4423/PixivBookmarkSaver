<?php

declare(strict_types=1);

require_once __DIR__ . '/../Models/Bookmark.php';
require_once __DIR__ . '/../Models/Illust.php';
require_once __DIR__ . '/../Models/IllustFile.php';
require_once __DIR__ . '/../Repositories/PixivWebRepository.php';

class PixivWebService
{

    private PixivWebRepository $pixivWebRepository;

    public function __construct(string $cookie)
    {
        $this->pixivWebRepository = new PixivWebRepository($cookie);
    }

    /**
     * @param string|int $userId
     * @param bool $isPublic
     * @return ?Bookmark[]
     */
    public function getBookmarks(string|int $userId, bool $isPublic): ?array
    {
        /**
         * @var Bookmark[] $bookmarks
         */
        $bookmarks = [];

        $offset = 0;
        $limit = 48;
        do {
            $result = $this->pixivWebRepository->getBookmarks($userId, $offset, $limit, $isPublic);
            if ($result === null) {
                return null;
            }

            $json = json_decode($result, true);
            if ($json['error']) {
                return null;
            }

            foreach ($json['body']['works'] as $work) {
                $bookmarks[] = new Bookmark($work);
            }

            $offset += $limit;
            $hasNextPage = $offset < $json['body']['total'];
            if ($hasNextPage) {
                sleep(1);
            }
        } while ($hasNextPage);

        return $bookmarks;
    }

    /**
     * @param string|int $illustId
     * @return ?Illust
     */
    public function getIllust(string|int $illustId): ?Illust
    {
        $result = $this->pixivWebRepository->getIllust($illustId);
        if ($result === null) {
            return null;
        }

        $json = json_decode($result, true);
        if ($json['error']) {
            return null;
        }

        return new Illust($json['body']);
    }

    /**
     * @param Illust $illust
     * @return ?IllustFile[]
     */
    public function getIllustFiles(Illust $illust): ?array
    {
        $count = $illust->getPageCount();
        $originalImageUrl = $illust->getUrls()->getOriginal();

        $illustFiles = [];
        for ($i = 0; $i < $count; $i++) {
            $url = preg_replace('/^(.+_p)\d+(\..+)$/', '${1}' . $i . '${2}', $originalImageUrl);
            $fileName = basename($url);

            $image = $this->pixivWebRepository->getIllustImage($url);
            if ($image === null) {
                return null;
            }

            $illustFiles[] = new IllustFile($fileName, $image);
            if ($i < ($count - 1)) {
                sleep(1);
            }
        }
        return $illustFiles;
    }
}
