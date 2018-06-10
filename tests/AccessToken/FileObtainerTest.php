<?php

namespace Tests\AccessToken;

use g9rga\phpFcm\src\AccessToken\FileObtainer;
use PHPUnit\Framework\TestCase;
use \InvalidArgumentException;

class FileObtainerTest extends TestCase
{
    public function testCreateWrongFilePath()
    {
        $filePath = '';
        $this->expectException(InvalidArgumentException::class);
        new FileObtainer($filePath);
    }

    public function testWrongFileFormat()
    {
        $this->expectException(InvalidArgumentException::class);
        new FileObtainer(TEST_FIXTURES_PATH . '/cred_file_wrong_json.json');
    }

    public function testNormalFile()
    {
        $data = json_decode(file_get_contents(TEST_FIXTURES_PATH . '/cred_file.json'), true);
        $fileObtainer = new FileObtainer(TEST_FIXTURES_PATH . '/cred_file.json');
        $this->assertEquals($data['type'], $fileObtainer->getAccountType());
        $this->assertEquals($data['project_id'], $fileObtainer->getProjectName());
        $this->assertEquals($data['private_key'], $fileObtainer->getPrivateKey());
        $this->assertEquals($data['client_email'], $fileObtainer->getClientEmail());
        $this->assertEquals($data['client_id'], $fileObtainer->getClientId());
    }
}
