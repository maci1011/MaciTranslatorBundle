<?php

namespace Maci\TranslatorBundle\Twig;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

use Maci\TranslatorBundle\Entity\Language;
use Maci\TranslatorBundle\Entity\LanguageTranslation;

class TranslatorExtension extends \Twig_Extension
{
    private $em;

    private $sc;

    private $ls;

    /**
     * Constructor
     */
    public function __construct(EntityManager $doctrine, SecurityContext $securityContext, $locales)
    {
        $this->em = $doctrine;
        $this->sc = $securityContext;
        $this->ls = $locales;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('matra', array($this, 'translate')),
        );
    }

    public function translate($label, $default = null)
    {
        if ($this->sc->isGranted('ROLE_ADMIN')) {
            $item = $this->em->getRepository('MaciTranslatorBundle:Language')->findOneByLabel($label);
            if (!$item) {
                $item = new Language;
                $item->setLabel($label);

                foreach ($this->ls as $locale) {
                    $translation = new LanguageTranslation();
                    $translation->setLocale( $locale );
                    $item->addTranslation($translation);
                }

                $this->em->persist($item);
                $this->em->flush();
            }
        }
        return $this->em->getRepository('MaciTranslatorBundle:Language')->getTextFromLabel($label, $default);
    }

    public function getName()
    {
        return 'maci_translator_extension';
    }
}

