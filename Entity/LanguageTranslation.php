<?php

namespace Maci\TranslatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LanguageTranslation
 */
class LanguageTranslation implements \A2lix\I18nDoctrineBundle\Doctrine\Interfaces\OneLocaleInterface
{
    use \A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translation;

    /**
     * @var string
     */
    private $text;

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
}
