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
        $id = 0;
        $item = $this->em->getRepository('MaciTranslatorBundle:Language')->findOneByLabel($label);

        if ( $item ) {
            $id = $item->getId();
        }

        return $id;
    }

    public function getName()
    {
        return 'maci_translatorid_extension';
    }
}

