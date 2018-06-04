<?php

namespace g9rga\phpFcm\src\Notification;

class AndroidNotification extends BaseNotification
{
    public const PRIORITY_NORMAL = 'NORMAL';
    public const PRIORITY_HIGH = 'HIGH';

    /**
     * @var string
     */
    private $priority = self::PRIORITY_NORMAL;

    /**
     * @var string
     */
    private $collapseKey = '';

    /**
     * @var int
     */
    private $ttl;

    /**
     * @var string
     */
    private $restrictedPackageName;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var string
     */
    private $icon = '';

    /**
     * @var string
     */
    private $color = '';

    /**
     * @var string
     */
    private $sound;

    /**
     * @var string
     */
    private $tag = '';

    /**
     * @var string
     */
    private $clickAction = '';

    /**
     * @var string
     */
    private $bodyLocKey = '';

    /**
     * @var array
     */
    private $bodyLocArgs = [];

    /**
     * @var string
     */
    private $titleLocKey = '';

    /**
     * @var array
     */
    private $titleLocArgs = [];

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = [
            'collapse_key' => $this->collapseKey,
            'priority' => $this->priority,
            'ttl' => $this->ttl,
            'restricted_package_name' => $this->restrictedPackageName,
            'notification' => [
                'icon' => $this->icon,
                'color' => $this->color,
                'sound' => $this->sound,
                'tag' => $this->tag,
                'click_action' => $this->clickAction,
                'body_loc_key' => $this->bodyLocKey,
                'body_loc_args' => $this->bodyLocArgs,
                'title_loc_key' => $this->titleLocKey,
                'title_loc_args' => $this->titleLocArgs
            ]
        ];

        if ($this->data) {
            $data['data'] = $this->data;
        }

        return $data;
    }

    /**
     * @param string $priority
     *
     * @return $this
     */
    public function setPriority(string $priority)
    {
        if (!in_array($priority, [self::PRIORITY_NORMAL, self::PRIORITY_HIGH])) {
            throw new \InvalidArgumentException('Unsupported priority');
        }
        $this->priority = $priority;

        return $this;
    }

    /**
     * @param string $collapseKey
     *
     * @return $this
     */
    public function setCollapseKey(string $collapseKey)
    {
        $this->collapseKey = $collapseKey;

        return $this;
    }

    /**
     * @param int $ttl
     *
     * @return $this
     */
    public function setTtl(int $ttl)
    {
        $this->ttl = $ttl . 's';

        return $this;
    }

    /**
     * @param string $restrictedPackageName
     *
     * @return $this
     */
    public function setRestrictedPackageName(string $restrictedPackageName)
    {
        $this->restrictedPackageName = $restrictedPackageName;

        return $this;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data)
    {
        foreach ($data as &$value) {
            $value = (string)$value;
        }

        $this->data = $data;

        return $this;
    }

    /**
     * @param string $icon
     *
     * @return $this
     */
    public function setIcon(string $icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @param string $color
     *
     * @return $this
     */
    public function setColor(string $color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @param string $sound
     *
     * @return $this
     */
    public function setSound(string $sound)
    {
        $this->sound = $sound;

        return $this;
    }

    /**
     * @param string $tag
     *
     * @return $this
     */
    public function setTag(string $tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @param string $clickAction
     *
     * @return $this
     */
    public function setClickAction(string $clickAction)
    {
        $this->clickAction = $clickAction;

        return $this;
    }

    /**
     * @param string $bodyLocKey
     *
     * @return $this
     */
    public function setBodyLocKey(string $bodyLocKey)
    {
        $this->bodyLocKey = $bodyLocKey;

        return $this;
    }

    /**
     * @param array $bodyLocArgs
     *
     * @return $this
     */
    public function setBodyLocArgs(array $bodyLocArgs)
    {
        $this->bodyLocArgs = $bodyLocArgs;

        return $this;
    }

    /**
     * @param string $titleLocKey
     *
     * @return $this
     */
    public function setTitleLocKey(string $titleLocKey)
    {
        $this->titleLocKey = $titleLocKey;

        return $this;
    }

    /**
     * @param array $titleLocArgs
     *
     * @return $this
     */
    public function setTitleLocArgs(array $titleLocArgs)
    {
        $this->titleLocArgs = $titleLocArgs;

        return $this;
    }
}
