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
        $query = $this->createQueryBuilder('g')
            ->leftJoin('Nurix\CatalogBundle\Entity\Characteristic', 'c', 'WITH', 'c.goodId = g.id')
            ->orWhere("g.name like :search")
            ->orWhere('g.shortDescription like :search')
            ->orWhere('g.fullDesctiption like :search')
            ->orWhere('c.value like :search')
            ->setParameter('search', '%' . $searchText . '%');

        return $query->getQuery()->getResult();

    }

    public function paginateGoods()
    {
        $query = $this->createQueryBuilder('q')
            ->where('q.active = 1')
            ->orderBy('q.id', 'DESC');

        return $query;
    }

    public function getSamePositionsForGood(Goods $good)
    {
        $minPrice = $good->getPrice() * 0.9;
        $maxPrice = $good->getPrice() * 1.1;
        $qb = $this->createQueryBuilder('p');
        $query = $qb
            //->andWhere('p.catalog = :catalog')
            ->andWhere('p.id <> :id')
            ->andWhere('p.price > :minprice ')
            ->andWhere('p.price < :maxprice ')
            //->setParameter('catalog', $good->getCatalog())
            ->setParameter('id', $good->getId())
            ->setParameter('minprice', $minPrice)
            ->setParameter('maxprice', $maxPrice)
            ->getQuery();
        return $query->getResult();
    }
}