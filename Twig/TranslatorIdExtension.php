<?php

namespace Maci\TranslatorBundle\Twig;

use Maci\TranslatorBundle\Controller\TranslatorController;

class TranslatorIdExtension extends \Twig_Extension
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
            new \Twig_SimpleFilter('matraid', array($this, 'translateid')),
        );
    }

    public function translateid($label)
    {
        return $this->tc->getId($label);
    }

    public function getName()
    {
        return 'maci_translatorid_extension';
    }
}

