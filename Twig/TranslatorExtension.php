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
            new \Twig_SimpleFilter('matra', array($this, 'translate')),
        );
    }

    public function translate($label, $default = null)
    {
        return $this->tc->getText($label, $default);
    }

    public function getName()
    {
        return 'maci_translator_extension';
    }
}

