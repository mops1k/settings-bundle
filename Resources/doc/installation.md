Installation
============

1) Download via composer:
```bash
$ composer require jmd/settings-bundle dev-master
```

2) Add to `app/AppKernel.php`:
```php
$bundles = array(
    ...
    new JMD\SettingsBundle\JMDSettingsBundle(),
);
```

3) Create `Settings` entity
```php
<?php
namespace Acme\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMD\SettingsBundle\Doctrine\Model\SettingsInterface;

/**
 * @ORM\Entity
 * @ORM\Table()
 */
class Settings implements SettingsInterface
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=249, nullable=false)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $value;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Settings
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return self
     */
    public function setNew($name, $value)
    {
        $this->name = $name;
        $this->value = $value;

        return $this;
    }
}
```

4) Add to `app/config/config.yml`:
```yaml
jmd_settings:
    entity:     AcmeDemoBundle:Settings
```

Where `AcmeDemoBundle:Settings` is your `Settings` entity.

5) Use it where you need.

In controller like:
```php
$settings = $this->get('jmd.settings');

// get setting name 'setting'
// if exist or getting 'default_value' as value
$settings->getOne('setting', 'default_value');

// mass get settings
$settings->getSettings([])

// add setting
$settings->addSetting('name', 'value');

...etc...
```

In twig:
```twig
{{ 'setting'|getOneSetting('default') }}
{% getOneSetting('setting', 'default') %}
```
