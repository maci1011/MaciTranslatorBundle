<?php

namespace Maci\TranslatorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Maci\TranslatorBundle\Entity\Language;

class TranslatorController extends Controller
{
	private $om;

	private $request;

    private $locales;

    private $loaded;

	public function __construct(ObjectManager $objectManager, RequestStack $requestStack, $locales)
	{
    	$this->om = $objectManager;
        $this->request = $requestStack->getCurrentRequest();
        $this->locales = $locales;

        $this->loaded = array();
    }

    public function getText($label, $default = null)
    {
        if (array_key_exists($label, $this->loaded)) {
            $item = $this->loaded[$label];
        } else {
            $item = $this->om->getRepository('MaciTranslatorBundle:Language')->findOneByLabel($label);
            if (!$item) {
                $item = $this->createItem($label, $default);
            }
            $this->loaded[$label] = $item;
        }

        return $item->getText();
    }

    public function getId($label)
    {
        return $this->om->getRepository('MaciTranslatorBundle:Language')->getIdFromLabel($label);
    }

    public function getLabel($name, $default = null)
    {
        if (is_numeric($name)) {
            $name = 'label.' . $name;
        }
        if (!strlen($name)) {
            if (strlen($default)) {
                $name = strtolower($default);
                $name = str_replace(' ', '_', $name);
                $name = substr($name,0,31);
            } else {
                return '';
            }
        } elseif (strpos('[', $name)) {
            $name = str_replace('[', '.', $name);
            $name = str_replace(']', '', $name);
        }
        return $this->getText(('form.'.$name), $default);
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

        return $item;
    }

    public function getLocales()
    {
        return $this->locales;
    }
}
