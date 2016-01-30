<?php

namespace JMD\SettingsBundle\Twig\Extension;

use JMD\SettingsBundle\Service\Settings as Executive;

class Settings extends \Twig_Extension
{
    /** @var Executive */
    protected $settings;

    /**
     * Settings constructor.
     * @param Executive $settings
     */
    public function __construct(Executive $settings)
    {
        $this->settings = $settings;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('getOneSetting', [ $this->settings, 'getOne' ])
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('getOneSetting', [ $this->settings, 'getOne' ])
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'jmd_settings';
    }
}
