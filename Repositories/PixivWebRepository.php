<?php

declare(strict_types=1);

class PixivWebRepository
{

    const PIXIV_BASE_URL = 'https://www.pixiv.net';

    const USER_AGENT = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.64 Safari/537.36';

    private string $cookie;

    public function __construct(string $cookie)
    {
        $this->cookie = $cookie;
    }

    public function getBookmarks(string|int $userId, int $offset = 0, int $limit = 48, bool $isPublic = true, string $lang = 'ja'): ?string
    {
        $param = [
            'tag' => '',
            'offset' => $offset,
            'limit' => $limit,
            'rest' => $isPublic ? 'show' : 'hide',
            'lang' => $lang,
        ];
        $url = self::PIXIV_BASE_URL . "/ajax/user/${userId}/illusts/bookmarks?" . http_build_query($param);
        return $this->get($url);
    }

    public function getIllustDetail(string|int $illustId): ?string
    {
        $url = self::PIXIV_BASE_URL . "/ajax/illust/${illustId}";
        return $this->get($url);
    }

    private function get(string $url): ?string
    {
        $headers = [
            'Accept: application/json',
            'Cookie: ' . $this->cookie,
            'User-Agent: ' . self::USER_AGENT,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        $output = curl_exec($ch);
        curl_close($ch);

        return ($output === false) ? null : $output;
    }

    public function getIllustImage(string $url): ?string
    {
        $headers = [
            'Referer: ' . self::PIXIV_BASE_URL,
            'User-Agent: ' . self::USER_AGENT,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        $output = curl_exec($ch);
        curl_close($ch);

        return ($output === false) ? null : $output;
    }
}
