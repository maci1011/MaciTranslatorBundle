<?php

namespace Maci\TranslatorBundle\Twig;

use Maci\TranslatorBundle\Controller\TranslatorController;

class TranslatorExtension extends \Twig_Extension
{
    private $tc;

    /**
     * Constructor
     */
    public function __construct(TranslatorController $tc)
    {
        $this->tc = $tc;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('matra', array($this, 'getText')),
            new \Twig_SimpleFilter('matit', array($this, 'getItem')),
            new \Twig_SimpleFilter('matla', array($this, 'getLabel')),
            new \Twig_SimpleFilter('matme', array($this, 'getMenu')),
            new \Twig_SimpleFilter('matro', array($this, 'getRoute'))
        );
    }

    public function getLabel($label, $default = null)
    {
        return $this->tc->getLabel($label, $default);
    }

    public function getMenu($label, $default = null)
    {
        return $this->tc->getMenu($label, $default);
    }

    public function getText($label, $default = null)
    {
        return $this->tc->getText($label, $default);
    }

    public function getRoute($label, $default = null)
    {
        return $this->tc->getRoute($label, $default);
    }

    public function getItem($label, $default = null)
    {
        return $this->tc->getItem($label, $default);
    }

    public function getName()
    {
        return 'maci_translator_extension';
    }
}

