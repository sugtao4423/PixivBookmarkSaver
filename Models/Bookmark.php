<?php

declare(strict_types=1);

class Bookmark
{

    protected string $id;
    protected string $title;
    protected string $description;
    protected string $alt;
    protected int $illustType;

    /**
     * @var string[]
     */
    protected array $tags;

    protected string $userId;
    protected string $userName;
    protected string $url;
    protected int $width;
    protected int $height;
    protected int $pageCount;
    protected bool $isBookmarkable;
    protected bool $isUnlisted;
    protected bool $isMasked;
    protected string $profileImageUrl;
    protected int $createDate;
    protected int $updateDate;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->alt = $data['alt'];
        $this->illustType = $data['illustType'];
        $this->tags = $data['tags'];
        $this->userId = $data['userId'];
        $this->userName = $data['userName'];
        $this->url = $data['url'];
        $this->width = $data['width'];
        $this->height = $data['height'];
        $this->pageCount = $data['pageCount'];
        $this->isBookmarkable = $data['isBookmarkable'];
        $this->isUnlisted = $data['isUnlisted'];
        $this->isMasked = $data['isMasked'];
        $this->profileImageUrl = $data['profileImageUrl'];
        $this->createDate = strtotime($data['createDate']);
        $this->updateDate = strtotime($data['updateDate']);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAlt(): string
    {
        return $this->alt;
    }

    public function getIllustType(): int
    {
        return $this->illustType;
    }

    /**
     * @return string[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getPageCount(): int
    {
        return $this->pageCount;
    }

    public function isBookmarkable(): bool
    {
        return $this->isBookmarkable;
    }

    public function isUnlisted(): bool
    {
        return $this->isUnlisted;
    }

    public function isMasked(): bool
    {
        return $this->isMasked;
    }

    public function getProfileImageUrl(): string
    {
        return $this->profileImageUrl;
    }

    public function getCreateDate(): int
    {
        return $this->createDate;
    }

    public function getUpdateDate(): int
    {
        return $this->updateDate;
    }
}
