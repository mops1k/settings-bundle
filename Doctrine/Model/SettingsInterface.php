<?php

namespace JMD\SettingsBundle\Doctrine\Model;

interface SettingsInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getValue();

    /**
     * @param string $value
     * @return SettingsInterface
     */
    public function setValue($value);

    /**
     * @param string $name
     * @return SettingsInterface
     */
    public function setName($name);

    /**
     * @param string $name
     * @param string $value
     * @return self
     */
    public function setNew($name, $value);
}
