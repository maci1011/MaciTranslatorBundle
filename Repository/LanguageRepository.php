<?php

namespace Maci\TranslatorBundle\Repository;

use Doctrine\ORM\EntityRepository;

class LanguageRepository extends EntityRepository
{
	private $lang_list = false;

	public function getList()
	{
		if (!$this->lang_list) {
			$q = $this->createQueryBuilder('l');
			$q
				->orderBy('l.id', 'ASC')
			;
			$res = $q->getQuery()->getResult();
			$this->lang_list = array();
			foreach ($res as $key => $value) {
				$this->lang_list[$value->getLabel()] = $value->getText();
			}
		}
		return $this->lang_list;
	}
}
