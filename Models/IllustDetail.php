<?php

declare(strict_types=1);

require_once __DIR__ . '/IllustDetailUrls.php';
require_once __DIR__ . '/IllustDetailTags.php';

class IllustDetail
{

    protected string $illustId;
    protected string $illustTitle;
    protected string $illustComment;
    protected string $id;
    protected string $title;
    protected string $description;
    protected string $alt;
    protected int $illustType;
    protected IllustDetailUrls $urls;
    protected IllustDetailTags $tags;
    protected string $userId;
    protected string $userName;
    protected string $userAccount;
    protected int $width;
    protected int $height;
    protected int $pageCount;
    protected int $createDate;
    protected int $uploadDate;

    public function __construct(array $data)
    {
        $this->illustId = $data['illustId'];
        $this->illustTitle = $data['illustTitle'];
        $this->illustComment = $data['illustComment'];
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->alt = $data['alt'];
        $this->illustType = $data['illustType'];
        $this->urls = new IllustDetailUrls($data['urls']);
        $this->tags = new IllustDetailTags($data['tags']);
        $this->userId = $data['userId'];
        $this->userName = $data['userName'];
        $this->userAccount = $data['userAccount'];
        $this->width = $data['width'];
        $this->height = $data['height'];
        $this->pageCount = $data['pageCount'];
        $this->createDate = strtotime($data['createDate']);
        $this->uploadDate = strtotime($data['uploadDate']);
    }

    public function getIllustId(): string
    {
        return $this->illustId;
    }

    public function getIllustTitle(): string
    {
        return $this->illustTitle;
    }

    public function getIllustComment(): string
    {
        return $this->illustComment;
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

    public function getUrls(): IllustDetailUrls
    {
        return $this->urls;
    }

    public function getTags(): IllustDetailTags
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

    public function getUserAccount(): string
    {
        return $this->userAccount;
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

    public function getCreateDate(): int
    {
        return $this->createDate;
    }

    public function getUploadDate(): int
    {
        return $this->uploadDate;
    }
}
