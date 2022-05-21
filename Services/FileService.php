<?php

declare(strict_types=1);

require_once __DIR__ . '/../Repositories/FileRepository.php';

class FileService
{

    private FileRepository $fileRepository;

    public function __construct(string|int $userId)
    {
        $this->fileRepository = new FileRepository($userId);
    }

    /**
     * @param IllustFile $illustFile
     * @return bool successful
     */
    public function saveIllustFile(IllustFile $illustFile): bool
    {
        return $this->fileRepository->saveFile(
            $illustFile->getFileName(),
            $illustFile->getFileContent()
        );
    }

    /**
     * @param IllustFile[] $illustFiles
     * @return bool all successful
     */
    public function saveIllustFiles(array $illustFiles): bool
    {
        foreach ($illustFiles as $file) {
            if (!$this->saveIllustFile($file)) {
                return false;
            }
        }
        return true;
    }
}
