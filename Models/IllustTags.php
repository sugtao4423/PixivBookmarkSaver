<?php

declare(strict_types=1);

require_once __DIR__ . '/IllustTag.php';

class IllustTags
{

    protected string $authorId;
    protected bool $isLocked;
    protected bool $writable;

    /**
     * @var IllustTag[]
     */
    protected array $tags;

    public function __construct(array $data)
    {
        $this->authorId = $data['authorId'];
        $this->isLocked = $data['isLocked'];
        $this->writable = $data['writable'];
        $this->tags = array_map(function (array $tag) {
            return new IllustTag($tag);
        }, $data['tags']);
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function getIsLocked(): bool
    {
        return $this->isLocked;
    }

    public function getWritable(): bool
    {
        return $this->writable;
    }

    /**
     * @return IllustTag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }
}
