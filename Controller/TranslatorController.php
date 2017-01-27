<?php

namespace Maci\TranslatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Maci\TranslatorBundle\Entity\Language;

class TranslatorController extends Controller
{
	private $om;

	private $sc;

	private $user;

    private $locales;

	public function __construct(ObjectManager $objectManager, RequestStack $requestStack, $locales)
	{
    	$this->om = $objectManager;
        $this->request = $requestStack->getCurrentRequest();
        $this->locales = $locales;
    }

    public function getText($label, $default = null)
    {
        $item = $this->om->getRepository('MaciTranslatorBundle:Language')->findOneByLabel($label);
        if (!$item) {
            $this->createItem($label, $default);
        }
        return $this->om->getRepository('MaciTranslatorBundle:Language')->getTextFromLabel($label, $default);
    }

    public function getId($label)
    {
        if ($this->sc->isGranted('ROLE_ADMIN')) {
            return $this->om->getRepository('MaciTranslatorBundle:Language')->getIdFromLabel($label);
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
        } elseif (strpos('[', $name)) {
            $name = str_replace('[', '.', $name);
            $name = str_replace(']', '', $name);
        }
        $label = 'form.' . $name;
        $item = $this->om->getRepository('MaciTranslatorBundle:Language')->findOneByLabel($label);
        if (!$item) {
            $this->createItem($label, $default);
        }
        return $this->om->getRepository('MaciTranslatorBundle:Language')->getTextFromLabel($label, $default);
    }

    public function createItem($label, $default = null)
    {
        $item = new Language;
        $item->setLabel($label);

        if (!strlen(trim($default))) {
            $default = null;
        }

        $item->setLocale($this->request->getLocale());
        $item->setText( $default );

        $this->om->persist($item);
        $this->om->flush();
    }

    public function getLocales()
    {
        return $this->locales;
    }
}
