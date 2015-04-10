<?php

namespace Maci\TranslatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

use Maci\TranslatorBundle\Entity\Language;
use Maci\TranslatorBundle\Entity\LanguageTranslation;

class TranslatorController extends Controller
{
	private $em;

	private $sc;

	private $user;

    private $locales;

	public function __construct(EntityManager $doctrine, SecurityContext $securityContext, $locales)
	{
    	$this->em = $doctrine;
	    $this->sc = $securityContext;
	    // $this->user = $securityContext->getToken()->getUser();
        $this->locales = $locales;
    }

    public function getText($label, $default = null)
    {
        $item = $this->em->getRepository('MaciTranslatorBundle:Language')->findOneByLabel($label);
        if (!$item) {
            $this->createItem($label, $default);
        }
        return $this->em->getRepository('MaciTranslatorBundle:Language')->getTextFromLabel($label, $default);
    }

    public function getId($label)
    {
        if ($this->sc->isGranted('ROLE_ADMIN')) {
            return $this->em->getRepository('MaciTranslatorBundle:Language')->getIdFromLabel($label);
        }
        return false;
    }

    public function getLabel($name, $default = null)
    {
        if (!strlen($name) || is_numeric($name)) {
            if (strlen($default)) {
                $name = strtolower($default);
                $name = str_replace(' ', '_', $name);
            } else {
                $name = 'label.' . rand(100000, 999999);
            }
        }
        $label = 'form.' . $name;
        $item = $this->em->getRepository('MaciTranslatorBundle:Language')->findOneByLabel($label);
        if (!$item) {
            $this->createItem($label, $default);
        }
        return $this->em->getRepository('MaciTranslatorBundle:Language')->getTextFromLabel($label, $default);
    }

    public function createItem($label, $default)
    {
        $item = new Language;
        $item->setLabel($label);
        if (!strlen(trim($default))) {
            $default = null;
        }
        foreach ($this->locales as $locale) {
            $translation = new LanguageTranslation();
            $translation->setText( $default );
            $translation->setLocale( $locale );
            $item->addTranslation($translation);
        }
        $this->em->persist($item);
        $this->em->flush();
    }

    public function getLocales()
    {
        return $this->locales;
    }
}
