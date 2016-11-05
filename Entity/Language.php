<?php

namespace Maci\TranslatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Language
 */
class Language
{
    use \A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translatable;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $label;

    protected $translations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set label
     *
     * @param string $label
     * @return Language
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }

    public function getName()
    {
        return $this->label;
    }

    /**
     * getName
     */
    public function getText()
    {
        return $this->__call('text', null);
    }

    /**
     * __toString()
     */
    public function __toString()
    {
        return $this->label;
    }
}
