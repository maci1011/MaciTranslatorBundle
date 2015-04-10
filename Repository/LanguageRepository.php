<?php

namespace Maci\TranslatorBundle\Repository;

use Doctrine\ORM\EntityRepository;

class LanguageRepository extends EntityRepository
{
    public function getTextFromLabel($label, $default = null)
    {
        $text = $default;
        $item = $this->_em->getRepository('MaciTranslatorBundle:Language')->findOneByLabel($label);

        if ( $item && strlen($item->getText()) ) {
            $text = $item->getText();
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
