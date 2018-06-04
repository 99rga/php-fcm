<?php

namespace g9rga\phpFcm\src;

use g9rga\phpFcm\src\Exception\NotificationRequiredException;
use g9rga\phpFcm\src\Notification\AndroidNotification;
use g9rga\phpFcm\src\Notification\ApnsNotification;
use g9rga\phpFcm\src\Notification\Notification;
use g9rga\phpFcm\src\Notification\WebPushNotification;
use g9rga\phpFcm\src\Target\TargetInterface;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

class Client
{
    private const DEFAULT_API_URL = 'https://fcm.googleapis.com/fcm/send';

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
     * @var bool
     */
    private $notificationCheck = false;

    /**
     * Client constructor
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->client = new GuzzleClient();
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     *
     * @return $this
     */
    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
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
     * @throws NotificationRequiredException
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send(TargetInterface $target): ResponseInterface
    {
        $formsParams = [
            $target->getType() => $target->getValue()
        ];
        $formsParams = $this->fillNotifications($formsParams);

        if (!$this->notificationCheck) {
            throw new NotificationRequiredException('At least one notification required');
        }
        $this->notificationCheck = false;
        return $this->client->post(self::DEFAULT_API_URL, [
            'headers' => [
                'Authorization' => sprintf('Bearer %s', $this->apiKey),
                'body' => json_encode($formsParams)
            ]
        ]);
    }

    private function fillNotifications(array $requestParams): array
    {
        if ($this->androidNotification) {
            $this->notificationCheck = true;
            $requestParams['android'] = $this->androidNotification->toArray();
        }
        if ($this->apnsNotification) {
            $this->notificationCheck = true;
            $requestParams['apns'] = $this->notification->toArray();
        }
        if ($this->webPushNotification) {
            $this->notificationCheck = true;
            $requestParams['webpush'] = $this->notification->toArray();
        }

        return $requestParams;
    }

    /**
     * @return AndroidNotification
     */
    public function getAndroidNotification(): AndroidNotification
    {
        return $this->androidNotification;
    }

    /**
     * @param AndroidNotification $androidNotification
     *
     * @return $this
     */
    public function setAndroidNotification(AndroidNotification $androidNotification)
    {
        $this->androidNotification = $androidNotification;

        return $this;
    }

    /**
     * @return ApnsNotification
     */
    public function getApnsNotification(): ApnsNotification
    {
        return $this->apnsNotification;
    }

    /**
     * @param ApnsNotification $apnsNotification
     *
     * @return $this
     */
    public function setApnsNotification(ApnsNotification $apnsNotification)
    {
        $this->apnsNotification = $apnsNotification;

        return $this;
    }

    /**
     * @return WebPushNotification
     */
    public function getWebPushNotification(): WebPushNotification
    {
        return $this->webPushNotification;
    }

    /**
     * @param WebPushNotification $webPushNotification
     *
     * @return $this
     */
    public function setWebPushNotification(WebPushNotification $webPushNotification)
    {
        $this->webPushNotification = $webPushNotification;

        return $this;
    }
}
