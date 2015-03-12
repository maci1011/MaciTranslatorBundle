<?php

namespace Maci\TranslatorBundle\Twig;

use Maci\TranslatorBundle\Controller\TranslatorController;

class TranslatorLabelExtension extends \Twig_Extension
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
            new \Twig_SimpleFilter('matraLabel', array($this, 'translateLabel')),
        );
    }

    public function translateLabel($name, $default = null)
    {
        return $this->tc->getLabel($name, $default);
    }

    public function getName()
    {
        return 'maci_translator_label_extension';
    }
}

