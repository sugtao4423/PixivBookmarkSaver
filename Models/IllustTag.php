<?php

declare(strict_types=1);

class IllustTag
{

    protected string $tag;
    protected bool $locked;
    protected bool $deletable;
    protected ?string $userId;
    protected ?string $userName;

    public function __construct(array $data)
    {
        $this->tag = $data['tag'];
        $this->locked = $data['locked'];
        $this->deletable = $data['deletable'];
        $this->userId = $data['userId'] ?? null;
        $this->userName = $data['userName'] ?? null;
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public function getLocked(): bool
    {
        return $this->locked;
    }

    public function getDeletable(): bool
    {
        return $this->deletable;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }
}
