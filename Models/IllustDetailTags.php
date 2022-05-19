<?php

declare(strict_types=1);

require_once __DIR__ . '/IllustDetailTag.php';

class IllustDetailTags
{

    protected string $authorId;
    protected bool $isLocked;
    protected bool $writable;

    /**
     * @var IllustDetailTag[]
     */
    protected array $tags;

    public function __construct(array $data)
    {
        $this->authorId = $data['authorId'];
        $this->isLocked = $data['isLocked'];
        $this->writable = $data['writable'];
        $this->tags = array_map(function (array $tag) {
            return new IllustDetailTag($tag);
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
     * @return IllustTagDetail[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }
}
