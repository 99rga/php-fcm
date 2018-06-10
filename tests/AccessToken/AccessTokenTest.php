<?php

namespace Tests\AccessToken;

use g9rga\phpFcm\src\AccessToken\AccessToken;
use g9rga\phpFcm\src\AccessToken\FileObtainer;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;

class AccessTokenTest extends TestCase
{
    public function testGetAccessToken()
    {
        $obtainer = new FileObtainer(TEST_FIXTURES_PATH . '/cred_file.json');
        $accessToken = new AccessToken($obtainer);
        $cacheMock = $this->getMockBuilder(CacheInterface::class)->getMock();
        $cacheMock->expects($this->once())->method('get')
            ->with($this->equalTo(AccessToken::ACCESS_TOKEN_CACHE_KEY))
            ->willReturn(['access_token' => 123]);
        $accessToken->setCache($cacheMock);
        $this->assertEquals(123, $accessToken->getAccessToken());
        $cacheMock = $this->getMockBuilder(CacheInterface::class)->getMock();
        $cacheMock->expects($this->once())->method('set')
            ->with(
                $this->equalTo(AccessToken::ACCESS_TOKEN_CACHE_KEY),
                $this->equalTo(['access_token' => 'ttt', 'expires_in' => 2000]),
                $this->equalTo(2000 - AccessToken::EXPIRES_LAG_SECONDS, 5)
            );
        $accessToken->setCache($cacheMock);
        $googleClientMock = $this->getMockBuilder(\Google_Client::class)->getMock();
        $googleClientMock->expects($this->once())->method('setAuthConfig')->with(
            $this->equalTo([
                'type' => $obtainer->getAccountType(),
                'client_id' => $obtainer->getClientId(),
                'client_email' => $obtainer->getClientEmail(),
                'private_key' => $obtainer->getPrivateKey()
            ])
        );
        $googleClientMock->expects($this->once())->method('setScopes')->with(
            $this->equalTo([AccessToken::SCOPE])
        );
        $googleClientMock->expects($this->once())->method('fetchAccessTokenWithAssertion')
            ->willReturn([
                'access_token' => 'ttt',
                'expires_in' => 2000
            ]);
        $accessToken->setGoogleClient($googleClientMock);
        $this->assertEquals('ttt', $accessToken->getAccessToken());
    }
}
