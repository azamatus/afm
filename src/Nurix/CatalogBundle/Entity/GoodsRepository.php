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

class GoodsRepository extends EntityRepository
{
    public function getGoodsByIds($goodsIds)
    {
        $em = $this->getEntityManager();
        $repository = $em->getRepository("CatalogBundle:Goods");
        $qb = $repository->createQueryBuilder('r');
        $query = $qb->add('where', $qb->expr()->in('r.id', array_keys($goodsIds)))
                ->getQuery();
//        var_dump($query->getResult());
//        die;
        return $query->getResult();
    }
}