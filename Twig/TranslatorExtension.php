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
        return $this->em->getRepository('MaciTranslatorBundle:Language')->getTextFromLabel($label, $default);
    }

    public function getName()
    {
        return 'maci_translator_extension';
    }
}

