<?php

namespace g9rga\phpFcm\src\AccessToken;

class FileObtainer implements ObtainerInterface
{
    /**
     * @var array
     */
    private $fileData;

    /**
     * Obtainer constructor.
     *
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException('File doesn\'t exist: ' . $filePath);
        }

        $this->fileData = json_decode(file_get_contents($filePath), true);
    }

    public function getAccountType(): string
    {
        return $this->fileData['type'];
    }

    public function getClientId(): string
    {
        return $this->fileData['client_id'];
    }

    public function getClientEmail(): string
    {
        return $this->fileData['client_email'];
    }

    public function getPrivateKey(): string
    {
        return $this->fileData['private_key'];
    }

    public function getProjectName(): string
    {
        return $this->fileData['project_id'];
    }
}
