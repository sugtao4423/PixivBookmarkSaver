<?php

declare(strict_types=1);

class FileRepository
{

    private string $fileDir;

    public function __construct(string|int $userId)
    {
        $this->fileDir = __DIR__ . "/../bookmarks-${userId}";
    }

    private function makeDirectory(): void
    {
        if (!file_exists($this->fileDir)) {
            mkdir($this->fileDir);
        }
    }

    /**
     * @param string $name
     * @param string $content
     * @return bool successful
     */
    public function saveFile(string $name, string $content): bool
    {
        $this->makeDirectory();
        $filePath = $this->fileDir . "/${name}";
        if (file_exists($filePath)) {
            echo "File already exists: $filePath" . PHP_EOL;
            return false;
        }

        $file = fopen($filePath, 'w');
        $result = fwrite($file, $content);
        fclose($file);

        return $result !== false;
    }
}
