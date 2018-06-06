<?php

namespace g9rga\phpFcm\src;

use g9rga\phpFcm\src\Cache\InMemoryCache;
use g9rga\phpFcm\src\Notification\AndroidNotification;
use g9rga\phpFcm\src\Notification\ApnsNotification;
use g9rga\phpFcm\src\Notification\BaseNotification;
use g9rga\phpFcm\src\Notification\WebPushNotification;
use g9rga\phpFcm\src\Request\RequestInterface;
use g9rga\phpFcm\src\Target\TargetInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\CacheInterface;

class Client
{
    private const API_URL = 'https://fcm.googleapis.com/v1/projects/%s/messages:send';

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var AndroidNotification
     */
    private $androidNotification;

    /**
     * @var ApnsNotification
     */
    private $apnsNotification;

    /**
     * @var WebPushNotification
     */
    private $webPushNotification;

    /**
     * @var BaseNotification
     */
    private $notification;

    /**
     * @var string
     */
    private $projectName;

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * Client constructor
     * @param RequestInterface $request
     * @param string $apiKey
     * @param string $projectName
     */
    public function __construct(RequestInterface $request, string $apiKey, string $projectName)
    {
        $this->request = $request;
        $this->cache = new InMemoryCache();
        $this->apiKey = $apiKey;
        $this->projectName = $projectName;
    }

    /**
     * @return RequestInterface
     */
    public function getClient(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @param RequestInterface $client
     *
     * @return $this
     */
    public function setClient(RequestInterface $client)
    {
        $this->request = $client;

        return $this;
    }

    /**
     * @param TargetInterface $target
     * @param BaseNotification $notification
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send(TargetInterface $target, BaseNotification $notification): ResponseInterface
    {
        $this->setNotification($notification);
        
        $formsParams = [
            $target->getType() => $target->getValue(),
            'notification' => [
                'title' => $this->notification->getTitle(),
                'body' => $this->notification->getBody()
            ]
        ];
        $formsParams = $this->fillNotifications($formsParams);

        return $this->request->sendPost(sprintf(self::API_URL, $this->projectName), [
            'headers' => [
                'Authorization' => sprintf('Bearer %s', $this->apiKey),
                'Content-Type' => 'application/json'
            ],
            'json' => ['message' => $formsParams]
        ]);
    }

    private function fillNotifications(array $requestParams): array
    {
        if ($this->androidNotification) {
            $requestParams['android'] = $this->androidNotification->toArray();
        }
        if ($this->apnsNotification) {
            $requestParams['apns'] = $this->apnsNotification->toArray();
        }
        if ($this->webPushNotification) {
            $requestParams['webpush'] = $this->webPushNotification->toArray();
        }

        return $requestParams;
    }

    private function setNotification(BaseNotification $notification) {
        $this->notification = $notification;
        switch (get_class($notification)) {
            case AndroidNotification::class:
                $this->androidNotification = $notification;
                break;
            case ApnsNotification::class:
                $this->apnsNotification = $notification;
                break;
            case WebPushNotification::class:
                $this->webPushNotification = $notification;
                break;
        }
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
