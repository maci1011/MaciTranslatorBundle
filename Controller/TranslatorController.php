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

    private $ids;

	public function __construct(ObjectManager $objectManager, RequestStack $requestStack, $locales)
	{
    	$this->om = $objectManager;
        $this->request = $requestStack->getCurrentRequest();
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

        $item->setLocale($this->request->getLocale());
        $item->setText( $default );

        $this->om->persist($item);
        $this->om->flush();

        return $item;
    }

    public function load()
    {
        if ($this->loaded) return;

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

    public function getLocales()
    {
        return $this->locales;
    }

    public function getText($label, $default = null)
    {
        $this->load();

        if (!array_key_exists($label, $this->loaded)) {
            $item = $this->createItem($label, $default);
            $this->loaded[$label] = $item->getText();
            $this->ids[$label] = $item->getId();
        }

        return $this->loaded[$label];
    }
}
