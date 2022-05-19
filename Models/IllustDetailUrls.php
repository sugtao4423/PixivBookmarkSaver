<?php

declare(strict_types=1);

class IllustDetailUrls
{

    protected string $original;

    public function __construct(array $data)
    {
        $this->original = $data['original'];
    }

    public function getOriginal(): string
    {
        return $this->original;
    }
}
