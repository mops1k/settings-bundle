<?php

namespace JMD\SettingsBundle\Service;

use Doctrine\ORM\EntityManager;
use JMD\SettingsBundle\Doctrine\Model\SettingsInterface;

/**
 * Class Settings
 * @package JMD\SettingsBundle\Service
 */
class Settings
{
    /** @var EntityManager $em */
    private $em;
    /**
     * @var string
     */
    private $entity;

    /**
     * Settings constructor.
     * @param EntityManager $em
     * @param string $entityName
     */
    public function __construct(
        EntityManager $em,
        $entityName
    ) {
        $this->em = $em;
        $this->entity = $entityName;
        $settingClass = $this->em->getRepository($this->entity)->getClassName();
        $class = new $settingClass;
        if (!($class instanceof SettingsInterface)) {
            throw new \LogicException(sprintf('Settings entity (%s) must implement SettingsInterface', $settingClass));
        }
    }

    /**
     * @param string $name
     * @param string|null $default
     * @return string
     */
    public function getOne(
        $name,
        $default = null
    ) {
        $setting = $this->em->getRepository($this->entity)->find($name);

        if (!$setting) {
            $this->addOne($name, $default);
        }

        return $setting ? $setting->getValue() : $default;
    }

    /**
     * @param array $array
     * @return array
     */
    public function getSettings(array $array = [])
    {
        $qb = $this->em->getRepository($this->entity)->createQueryBuilder('s');

        return $qb
            ->select('s')
            ->where($qb->expr()->in('s.name', $array))
            ->getQuery()
            ->getArrayResult()
        ;
    }

    /**
     * @param string $name
     * @param string $value
     * @return Settings
     */
    public function addOne(
        $name,
        $value
    ) {
        $settingClass = $this->em->getRepository($this->entity)->getClassName();

        /** @var \JMD\SettingsBundle\Doctrine\Model\SettingsInterface $setting */
        $setting = new $settingClass;
        $setting->setNew($name, $value);

        $this->em->persist($setting);
        $this->em->flush();

        return $this;
    }

    /**
     * @param array $array
     * @return $this
     */
    public function addSettings(array $array = [])
    {
        $settingClass = $this->em->getRepository($this->entity)->getClassName();

        foreach ($array as $key => $value) {
            $setting = new $settingClass;
            /** @var \JMD\SettingsBundle\Doctrine\Model\SettingsInterface $setting */
            $setting->setNew($key, $value);

            $this->em->persist($setting);
        }
        $this->em->flush();

        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function removeOne($name)
    {
        $setting = $this->em->getRepository($this->entity)->find($name);
        $this->em->remove($setting);

        $this->em->flush();

        return $this;
    }

    /**
     * @param array $array
     * @return $this
     */
    public function removeSettings(array $array = [])
    {
        foreach ($array as $value) {
            $setting = $this->em->getRepository($this->entity)->find($value);
            $this->em->remove($setting);
        }

        $this->em->flush();

        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function updateOne($name, $value)
    {
        /** @var \JMD\SettingsBundle\Doctrine\Model\SettingsInterface $setting */
        $setting = $this->em->getRepository($this->entity)->find($name);

        $setting->setValue($value);

        $this->em->persist($setting);
        $this->em->flush();

        return $this;
    }

    /**
     * @param array $array
     * @return $this
     */
    public function updateSettings($array = [])
    {
        foreach ($array as $key => $value) {
            /** @var \JMD\SettingsBundle\Doctrine\Model\SettingsInterface $setting */
            $setting = $this->em->getRepository($this->entity)->find($key);

            $setting->setValue($value);

            $this->em->persist($setting);
        }

        $this->em->flush();

        return $this;
    }
}
