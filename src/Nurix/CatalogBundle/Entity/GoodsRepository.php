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
		$query = $this->createQueryBuilder('g')
			->leftJoin('Nurix\CatalogBundle\Entity\Characteristic', 'c', 'WITH', 'c.goodId = g.id')
			->orWhere("g.name like :search")
			->orWhere('g.shortDescription like :search')
			->orWhere('g.fullDesctiption like :search')
			->orWhere('c.value like :search')
			->andWhere('g.active = 1')
			->setParameter('search', '%' . $searchText . '%');

		return $query->getQuery()->getResult();

	}

	public function getMainGoods()
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
			->where('p.active = 1')
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

	public function getSlider()
	{
		$last_updatedGoods = $this->createQueryBuilder('g')
            ->select('max(g.last_update)')
			->where('g.active = 1')
			->getQuery()->getDQL();

		$query = $this->createQueryBuilder('q')
			->where('q.active = 1')
			->andWhere('q.last_update in ('.$last_updatedGoods.')')
			->orderBy('q.name', 'ASC')
			->getQuery();

        return $query->getResult();
	}

	public function getGoods($cid)
	{
		if (!$cid)
		{
			$query = $this->getEntityManager()
				->createQuery("SELECT g FROM CatalogBundle:Goods g where g.active = 1")
				->getResult();
			return $query;
		}
		else
		{
			$query = $this->getEntityManager()
				->createQuery("SELECT g FROM CatalogBundle:Goods g where g.active = 1 and g.catalog in (select c.id from CatalogBundle:Catalog c where c.id = $cid or c.parent = $cid) order by g.name ASC")
				->getResult();
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

    public function getAvailableGoods()
    {
        $query = $this->createQueryBuilder('q')
            ->where('q.active = 1')
            ->andWhere('q.amount > 0')
			->orderBy('q.name', 'ASC');

        return $query;
    }
}