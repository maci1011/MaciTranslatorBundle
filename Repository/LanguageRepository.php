<?php

namespace Maci\TranslatorBundle\Repository;

use Doctrine\ORM\EntityRepository;

class LanguageRepository extends EntityRepository
{
    public function getTextFromLabel($label, $default = null)
    {
        $text = $label;
        $item = $this->_em->getRepository('MaciTranslatorBundle:Language')->findOneByLabel($label);

        if ( $item ) {
            $text = $item->getText();
        } elseif ($default) {
            $text = $default;
        }

        return $text;
    }

    public function getIdFromLabel($label)
    {
        $id = 0;
        $item = $this->_em->getRepository('MaciTranslatorBundle:Language')->findOneByLabel($label);

        if ( $item ) {
            $id = $item->getId();
        }

        return $id;
    }
}
