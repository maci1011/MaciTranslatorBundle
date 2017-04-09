<?php

namespace Maci\TranslatorBundle\Repository;

use Doctrine\ORM\EntityRepository;

class LanguageRepository extends EntityRepository
{
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
