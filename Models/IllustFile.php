<?php

declare(strict_types=1);

class IllustFile
{
    protected string $fileName;
    protected string $fileContent;

    public function __construct(string $fileName, string $fileContent)
    {
        $this->fileName = $fileName;
        $this->fileContent = $fileContent;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getFileContent(): string
    {
        return $this->fileContent;
    }
}
