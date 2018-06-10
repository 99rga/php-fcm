<?php

namespace g9rga\phpFcm\src\AccessToken;

use g9rga\phpFcm\src\Cache\InMemoryCache;
use Psr\SimpleCache\CacheInterface;

class AccessToken implements AccessTokenAwareInterface
{
    const ACCESS_TOKEN_CACHE_KEY = 'accessToken';

    const SCOPE = 'https://www.googleapis.com/auth/firebase.messaging';

    const EXPIRES_LAG_SECONDS = 10;
    
    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var ObtainerInterface
     */
    private $obtainer;

    /**
     * @var \Google_Client
     */
    private $googleClient;

    /**
     * Obtainer constructor.
     * @param ObtainerInterface
     */
    public function __construct(ObtainerInterface $obtainer)
    {
        $this->obtainer = $obtainer;
        $this->cache = new InMemoryCache();
        $this->googleClient = new \Google_Client();
    }

    public function getObtainer(): ObtainerInterface
    {
        return $this->obtainer;
    }

    public function getAccessToken(): string
    {
        $accessToken = $this->cache->get(self::ACCESS_TOKEN_CACHE_KEY);
        if ($accessToken) {
            return $accessToken['access_token'];
        }
        $result = $this->refreshAccessToken($this->obtainer);
        $accessToken = $result['access_token'];
        $this->cache->set(self::ACCESS_TOKEN_CACHE_KEY, $result, $result['expires_in'] - self::EXPIRES_LAG_SECONDS);
        return $accessToken;
    }

    private function refreshAccessToken(ObtainerInterface $obtainer)
    {
        $this->googleClient->setAuthConfig([
            'type' => $obtainer->getAccountType(),
            'client_id' => $obtainer->getClientId(),
            'client_email' => $obtainer->getClientEmail(),
            'private_key' => $obtainer->getPrivateKey(),
        ]);
        $this->googleClient->setScopes([self::SCOPE]);

        return $this->googleClient->fetchAccessTokenWithAssertion();
    }
    
    /**
     * @param CacheInterface $cache
     *
     * @return $this
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @param \Google_Client $googleClient
     *
     * @return $this
     */
    public function setGoogleClient(\Google_Client $googleClient)
    {
        $this->googleClient = $googleClient;

        return $this;
    }
}
