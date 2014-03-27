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
			->andWhere('r.active = 1')
			->getQuery();
		return $query->getResult();
	}

	public function searchGoods($searchText)
	{
		$query = $this->createQueryBuilder('q')
			//->leftJoin('Nurix\CatalogBundle\Entity\Characteristic', 'c', 'WITH', 'c.goodId = g.id')
			->orWhere("q.name like :search")
			->orWhere('q.shortDescription like :search')
			->orWhere('q.fullDesctiption like :search')
			//->orWhere('c.value like :search')
			->andWhere('q.active = 1')
			->setParameter('search', '%' . $searchText . '%');

		return $query->getQuery();

	}

	public function getMainGoods()
	{
		$query = $this->createQueryBuilder('q')
			->where('q.active = 1')
			->orderBy('q.id', 'DESC');

		return $query;
	}

	public function getRelativeProducts(Goods $good,$count)
	{
		$minPrice = $good->getPrice() * 0.9;
		$maxPrice = $good->getPrice() * 1.1;
		$qb = $this->createQueryBuilder('p');
		$query = $qb
			->where('p.active = 1')
			//->andWhere('p.catalog = :catalog')
			->andWhere('p.id <> :id')
			->andWhere('p.price > :minprice ')
			->andWhere('p.price < :maxprice ')
			//->setParameter('catalog', $good->getCatalog())
			->setParameter('id', $good->getId())
			->setParameter('minprice', $minPrice)
			->setParameter('maxprice', $maxPrice)
            ->setMaxResults($count)
			->getQuery();
		return $query->getResult();
	}

	public function getSlider($count)
	{
		$last_updatedDate = $this->createQueryBuilder('g')
            ->select('max(g.last_update)')
			->where('g.active = 1')
			->getQuery()->getSingleScalarResult();

		$query = $this->createQueryBuilder('q')
			->where('q.active = 1')
			->andWhere('q.last_update=:last_update')
			->orderBy('q.name', 'ASC')
            ->setParameter('last_update',$last_updatedDate)
            ->setMaxResults($count)
			->getQuery();

        return $query->getResult();
	}

	public function getGoods($cid)
	{
		if (!$cid)
		{
			$query = $this->createQueryBuilder('q')
                ->where('q.active = 1')
                ->getQuery();

			return $query;
		}
		else
		{
            /** @var $catalog Catalog */
            $catalog = $this->getEntityManager()->getRepository('CatalogBundle:Catalog')->find($cid);

			$query = $this->createQueryBuilder('q')
                ->where('q.active = 1')
                ->andWhere('q.catalog = :cid or q.catalog = :cparent')
                ->setParameter(':cid',$cid)
                ->setParameter(':cparent',$catalog->getParent())
                ->getQuery();
			return $query;
		}
	}

	public function deactivateAll()
	{
		$this->createQueryBuilder('g')
			->update('CatalogBundle:Goods', 'g')
			->set('g.active', 0)
			->getQuery()->execute();
	}

    public function deactivateAmountAll()
    {
        $this->createQueryBuilder('g')
            ->update('CatalogBundle:Goods', 'g')
            ->set('g.amount', 0)
            ->getQuery()->execute();
    }

    public function getAvailableGoods()
    {
        $query = $this->createQueryBuilder('q')
            ->where('q.active = 1')
            ->andWhere('q.amount > 0')
        ->getQuery();

        return $query;
    }

    public function incrementViews($goodId)
    {
        $this->createQueryBuilder('g')
            ->update('CatalogBundle:Goods', 'g')
            ->set('g.views', 'g.views + 1')
            ->where('g.id = :id')
            ->setParameter('id', $goodId)
            ->getQuery()->execute();
    }
}