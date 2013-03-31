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
        return $query->getResult();
    }

    public function searchGoods($searchText)
    {
        $query =  $this->createQueryBuilder('g')
            ->leftJoin('Nurix\CatalogBundle\Entity\Characteristic', 'c', 'WITH', 'c.goodId = g.id')
            ->orWhere("g.name like :search")
            ->orWhere('g.shortDescription like :search')
            ->orWhere('g.fullDesctiption like :search')
            ->orWhere('c.value like :search')
            ->setParameter('search','%'.$searchText.'%');

        return $query->getQuery()->getResult();

    }
}