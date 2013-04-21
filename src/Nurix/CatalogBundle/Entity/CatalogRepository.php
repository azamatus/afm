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

class CatalogRepository extends EntityRepository
{
    public function getGoods($cid)
    {
        return $this->getEntityManager()
            ->createQuery("SELECT g FROM CatalogBundle:Goods g where g.catalog in (select c.id from CatalogBundle:Catalog c where c.id = $cid or c.parent = $cid )")
            ->getResult();
    }


    public function getAll($rules = array()){
        $catalogs = $this->createQueryBuilder('c');

        if (!empty($rules['active']))
        {
            $catalogs->where('c.active = :a')
                ->setParameter('a', $rules['active']);
        }
        if (!empty($rules['parent'])){
            $catalogs->andWhere('c.parent = :a')
                ->setParameter('a', $rules['parent']);
        }

        return $catalogs->getQuery()->getResult();
    }

    public function getSubCatalog(){
        $subcatalog = $this->createQueryBuilder('s');
        return $subcatalog->where('s.parent_id is not null')->getQuery()->getResult();
    }
}
