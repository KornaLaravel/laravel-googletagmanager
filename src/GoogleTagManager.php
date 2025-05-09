<?php

namespace Spatie\GoogleTagManager;

use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;

class GoogleTagManager
{
    use Macroable;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var bool
     */
    protected $enabled;

    /**
     * @var string
     */
    protected $gtmScriptDomain;

    /**
     * @var \Spatie\GoogleTagManager\DataLayer
     */
    protected $dataLayer;

    /**
     * @var \Spatie\GoogleTagManager\DataLayer
     */
    protected $flashDataLayer;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $pushDataLayer;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $flashPushDataLayer;

    /**
     * @param string $id
     * @param string $gtmScriptDomain
     */
    public function __construct($id, $gtmScriptDomain)
    {
        $this->id = $id;
        $this->gtmScriptDomain = $gtmScriptDomain;
        $this->dataLayer = new DataLayer();
        $this->flashDataLayer = new DataLayer();
        $this->pushDataLayer = new Collection();
        $this->flashPushDataLayer = new Collection();

        $this->enabled = true;
    }

    /**
     * Return the Google Tag Manager id.
     *
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Return the Google Tag Manager script domain.
     *
     * @return string
     */
    public function gtmScriptDomain()
    {
        return $this->gtmScriptDomain;
    }

    /**
     * Check whether script rendering is enabled.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Enable Google Tag Manager scripts rendering.
     */
    public function enable()
    {
        $this->enabled = true;
    }

    /**
     * Disable Google Tag Manager scripts rendering.
     */
    public function disable()
    {
        $this->enabled = false;
    }

    /**
     * Add data to the data layer.
     *
     * @param array|string $key
     * @param mixed        $value
     */
    public function set($key, $value = null)
    {
        $this->dataLayer->set($key, $value);
    }

    /**
     * Retrieve the data layer.
     *
     * @return \Spatie\GoogleTagManager\DataLayer
     */
    public function getDataLayer()
    {
        return $this->dataLayer;
    }

    /**
     * Add data to the data layer for the next request.
     *
     * @param array|string $key
     * @param mixed        $value
     */
    public function flash($key, $value = null)
    {
        $this->flashDataLayer->set($key, $value);
    }

    /**
     * Retrieve the data layer's data for the next request.
     *
     * @return array
     */
    public function getFlashData()
    {
        return $this->flashDataLayer->toArray();
    }

    /**
     * Add data to be pushed to the data layer.
     *
     * @param array|string $key
     * @param mixed        $value
     */
    public function push($key, $value = null)
    {
        $pushItem = new DataLayer();
        $pushItem->set($key, $value);
        $this->pushDataLayer->push($pushItem);
    }

    /**
     * Retrieve the data layer's data for the next request.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPushData()
    {
        return $this->pushDataLayer;
    }

    /**
     * Add data to be pushed to the data layer for the next request.
     *
     * @param array|string $key
     * @param mixed        $value
     */
    public function flashPush($key, $value = null)
    {
        $pushItem = new DataLayer();
        $pushItem->set($key, $value);
        $this->flashPushDataLayer->push($pushItem);
    }

    /**
     * Retrieve the push data for the next request.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFlashPushData()
    {
        return $this->flashPushDataLayer;
    }

    /**
     * Clear the data layer.
     */
    public function clear()
    {
        $this->dataLayer = new DataLayer();
        $this->pushDataLayer = new Collection();
    }

    /**
     * Utility function to dump an array as json.
     *
     * @param  array $data
     * @return string
     */
    public function dump($data)
    {
        return (new DataLayer($data))->toJson();
    }
}
