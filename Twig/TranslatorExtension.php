<?php

namespace Maci\TranslatorBundle\Twig;

use Doctrine\ORM\EntityManager;

class TranslatorExtension extends \Twig_Extension
{

    private $em;

    /**
     * Constructor
     */
    public function __construct(EntityManager $doctrine)
    {
    	$this->em = $doctrine;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('matra', array($this, 'translate')),
        );
    }

    public function translate($label, $default = null)
    {
        $text = $label;
        $list = $this->em->getRepository('MaciTranslatorBundle:Language')->getList();

        if ( array_key_exists($label, $list) && 0<strlen($list[$label]) ) {
            $text = $list[$label];
        }
        elseif ($default) {
            $text = $default;
        }

        return $text;
    }

    public function getName()
    {
        return 'maci_translator_extension';
    }
}

