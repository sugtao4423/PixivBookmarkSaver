<?php

declare(strict_types=1);

class IllustUrls
{

    protected string $thumbnail;
    protected string $original;

    public function __construct(array $data)
    {
        $this->thumbnail = $data['thumb'];
        $this->original = $data['original'];
    }

    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    public function getOriginal(): string
    {
        return $this->original;
    }
}
