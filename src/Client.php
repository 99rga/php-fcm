<?php

namespace g9rga\phpFcm\src;

use g9rga\phpFcm\src\Cache\NullCache;
use g9rga\phpFcm\src\Notification\AndroidNotification;
use g9rga\phpFcm\src\Notification\ApnsNotification;
use g9rga\phpFcm\src\Notification\BaseNotification;
use g9rga\phpFcm\src\Notification\WebPushNotification;
use g9rga\phpFcm\src\Target\TargetInterface;
use GuzzleHttp\Client as GuzzleClient;
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
     * @var GuzzleClient
     */
    private $client;

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
     * @param string $apiKey
     * @param string $projectName
     */
    public function __construct(string $apiKey, string $projectName)
    {
        $this->client = new GuzzleClient();
        $this->apiKey = $apiKey;
        $this->projectName = $projectName;
        $this->cache = new NullCache();
    }

    /**
     * @return GuzzleClient
     */
    public function getClient(): GuzzleClient
    {
        return $this->client;
    }

    /**
     * @param GuzzleClient $client
     *
     * @return $this
     */
    public function setClient(GuzzleClient $client)
    {
        $this->client = $client;

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
        return $this->client->post(sprintf(self::API_URL, $this->projectName), [
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
}
