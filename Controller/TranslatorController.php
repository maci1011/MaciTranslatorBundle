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

    private $locale;

    private $locales;

    private $loaded;

    private $ids;

	public function __construct(ObjectManager $objectManager, RequestStack $requestStack, $locales)
	{
    	$this->om = $objectManager;
        $this->request = $requestStack->getCurrentRequest();
        $this->locale = $this->request ? $this->request->getLocale() : $locales[0];
        $this->locales = $locales;

        $this->loaded = false;
        $this->ids = array();
    }

    public function createItem($label, $default = null)
    {
        $item = new Language;
        $item->setLabel($label);

        if (!strlen(trim($default))) {
            $default = null;
        }

        $item->setLocale($this->locale);
        $item->setText( $default );

        $this->om->persist($item);
        $this->om->flush();

        return $item;
    }

    public function getLocales()
    {
        return $this->locales;
    }

    public function getCurrentLocale()
    {
        return $this->locale;
    }

    public function load()
    {
        if (is_array($this->loaded)) return;

        $this->loaded = array();

        $list = $this->om->getRepository('MaciTranslatorBundle:Language')->findBy(array(
            'locale' => $this->request->getLocale()
        ));

        foreach ($list as $item) {
            $this->loaded[$item->getLabel()] = $item->getText();
            $this->ids[$item->getLabel()] = $item->getId();
        }
    }

    public function getId($label)
    {
        if (!array_key_exists($label, $this->ids)) {
            return 0;
        }

        return $this->ids[$label];
    }

    public function getLabel($name, $default = null)
    {
        if (!strlen($name)) {
            if (strlen($default)) {
                $str = strtolower($default);
                $str = str_replace(' ', '_', $str);
                return ucfirst($str);
            } else {
                return '';
            }
        } elseif (is_numeric($name)) {
            $name = 'label.ID_' . $name;
        } elseif (strpos('[', $name)) {
            $name = str_replace('[', '.', $name);
            $name = str_replace(']', '', $name);
        }
        return $this->getItem(('label.'.$name), $default);
    }

    public function getMenu($name, $default = null)
    {
        return $this->getItem(('menu.'.$name), $default);
    }

    public function getText($name, $default = null)
    {
        return $this->getItem(('text.'.$name), $default);
    }

    public function getRoute($name, $default = null)
    {
        return $this->getItem(('routes.'.$name), $default);
    }

    public function getItem($name, $default = null)
    {
        $this->load();

        if (!array_key_exists($name, $this->loaded)) {
            $item = $this->createItem($name, $default);
            $this->loaded[$name] = $item->getText();
            $this->ids[$name] = $item->getId();
        }

        return $this->loaded[$name];
    }
}
