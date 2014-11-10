<?php

namespace Maci\TranslatorBundle\Twig;

use Doctrine\ORM\EntityManager;

class TranslatorIdExtension extends \Twig_Extension
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
            new \Twig_SimpleFilter('matraid', array($this, 'translate')),
        );
    }

    public function translate($label)
    {
        return $this->em->getRepository('MaciTranslatorBundle:Language')->getIdFromLabel($label);
    }

    public function getName()
    {
        return 'maci_translatorid_extension';
    }
}

