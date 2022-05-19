<?php

declare(strict_types=1);

require_once __DIR__ . '/../Models/Bookmark.php';
require_once __DIR__ . '/../Models/IllustDetail.php';
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
     * @return ?Bookmark[]
     */
    public function getBookmarks(string|int $userId): ?array
    {
        /**
         * @var Bookmark[] $bookmarks
         */
        $bookmarks = [];

        $offset = 0;
        $limit = 48;
        do {
            $result = $this->pixivWebRepository->getBookmarks($userId, $offset, $limit);
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
     * @return ?IllustDetail
     */
    public function getIllustDetail(string|int $illustId): ?IllustDetail
    {
        $result = $this->pixivWebRepository->getIllustDetail($illustId);
        if ($result === null) {
            return null;
        }

        $json = json_decode($result, true);
        if ($json['error']) {
            return null;
        }

        return new IllustDetail($json['body']);
    }

    /**
     * @param IllustDetail $illustDetail
     * @return ?IllustFile[]
     */
    public function getIllustFiles(IllustDetail $illustDetail): ?array
    {
        $count = $illustDetail->getPageCount();
        $originalImageUrl = $illustDetail->getUrls()->getOriginal();

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
