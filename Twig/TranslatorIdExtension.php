<?php

namespace Maci\TranslatorBundle\Twig;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class TranslatorIdExtension extends \Twig_Extension
{
    private $em;

    private $sc;

    /**
     * Constructor
     */
    public function __construct(EntityManager $doctrine, SecurityContext $securityContext)
    {
        $this->em = $doctrine;
        $this->sc = $securityContext;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('matraid', array($this, 'translateid')),
        );
    }

    public function translateid($label)
    {
        if ($this->sc->isGranted('ROLE_ADMIN')) {
            return $this->em->getRepository('MaciTranslatorBundle:Language')->getIdFromLabel($label);
        }
        return false;
    }

    public function getName()
    {
        return 'maci_translatorid_extension';
    }
}

