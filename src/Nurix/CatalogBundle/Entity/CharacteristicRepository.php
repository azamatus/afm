<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Admin
 * Date: 27.01.13
 * Time: 14:08
 * To change this template use File | Settings | File Templates.
 */
namespace Nurix\CatalogBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CharacteristicRepository extends EntityRepository
{
    public function  getGoodCharacteristic($id){

        $query = $this
        ->createQueryBuilder('r')
        ->innerJoin("CatalogBundle:CharacteristicType", 't', 'WITH', 'r.cTypeId = t.id')
        ->where('r.goodId = :good_id')
        ->setParameters(array('good_id' => $id))
        ->orderBy('t.section', 'ASC')
        ->getQuery();
        $char = $query->getResult();

        return $char;
    }
}

