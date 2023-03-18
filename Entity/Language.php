<?php

namespace Maci\TranslatorBundle\Entity;

use Symfony\Component\Intl\Locales;

/**
 * Language
 */
class Language
{
	/**
	 * @var integer
	 */
	private $id;

	/**
	 * @var string
	 */
	private $label;

	/**
	 * @var string
	 */
	private $text;

	/**
	 * @var string
	 */
	private $locale;

	/**
	 * Get id
	 *
	 * @return integer 
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set text
	 *
	 * @param string $text
	 * @return LanguageTranslation
	 */
	public function setText($text)
	{
		$this->text = $text;

		return $this;
	}

	/**
	 * Get text
	 *
	 * @return string 
	 */
	public function getText()
	{
		return $this->text;
	}

	/**
	 * Set label
	 *
	 * @param string $label
	 * @return Language
	 */
	public function setLabel($label)
	{
		$this->label = $label;

		return $this;
	}

	/**
	 * Get label
	 *
	 * @return string 
	 */
	public function getLabel()
	{
		return $this->label;
	}

	public function getName()
	{
		return $this->label;
	}

	public function setLocale($locale)
	{
		$this->locale = $locale;

		return $this;
	}

	public function getLocale()
	{
		return $this->locale;
	}

	public function getLocaleLabel()
	{
		$key = array_search($this->locale, $this->getLocaleChoices());
		if ($key) return $key;
		return ucwords($this->locale);
	}

	static public function getLocaleChoices()
	{
		$list = array_flip(Locales::getNames());
		$new = [];
		foreach ($list as $key => $value)
		{
			if (strlen($value) == 2)
				$new[ucfirst($key)] = $value;
		}
		$new['Option'] = 'option';
		return $new;
	}

	/**
	 * __toString()
	 */
	public function __toString()
	{
		return ($this->label ? $this->label : '');
	}
}
