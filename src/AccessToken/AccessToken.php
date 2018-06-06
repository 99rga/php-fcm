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
     * Obtainer constructor.
     * @param ObtainerInterface
     */
    public function __construct(ObtainerInterface $obtainer)
    {
        $this->obtainer = $obtainer;
        $this->cache = new InMemoryCache();
    }

    public function getObtainer(): ObtainerInterface
    {
        return $this->obtainer;
    }

    public function getAccessToken(): string
    {
        $accessToken = $this->cache->get(self::ACCESS_TOKEN_CACHE_KEY);
        if ($accessToken) {
            return $accessToken;
        }
        $result = $this->refreshAccessToken($this->obtainer);
        $accessToken = $result['access_token'];
        $this->cache->set(self::ACCESS_TOKEN_CACHE_KEY, $result, $result['expires_in'] - self::EXPIRES_LAG_SECONDS);
        return $accessToken;
    }

    private function refreshAccessToken(ObtainerInterface $obtainer)
    {
        $googleClient = new \Google_Client();
        $googleClient->setAuthConfig([
            'type' => $obtainer->getAccountType(),
            'client_id' => $obtainer->getClientId(),
            'client_email' => $obtainer->getClientEmail(),
            'private_key' => $obtainer->getPrivateKey(),
        ]);
        $googleClient->setScopes([self::SCOPE]);

        return $googleClient->fetchAccessTokenWithAssertion();
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
}
