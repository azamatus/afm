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
        if (!$cid){
            $query=$this->getEntityManager()
                ->createQuery("SELECT g FROM CatalogBundle:Goods g where g.active = 1")
                ->getResult();
            return $query;
    }
        else{
            $query = $this->getEntityManager()
                ->createQuery("SELECT g FROM CatalogBundle:Goods g where g.active = 1 and g.catalog in (select c.id from CatalogBundle:Catalog c where c.id = $cid or c.parent = $cid)")
                ->getResult();
            return $query;
        }
    }


    public function getAll($rules = array()){
        $catalogs = $this->createQueryBuilder('c');

        if (!empty($rules['active']))
        {
            $catalogs->where('c.active = :a')
                ->setParameter('a', $rules['active']);
        }

        if (isset($rules['parent'])){
            $catalogs->andWhere('c.parent = :a')
                ->setParameter('a', $rules['parent']);
        }
        else if (array_key_exists('parent',$rules))
        {

            $catalogs->andWhere('c.parent is null');
        }

        return $catalogs->getQuery()->getResult();
    }
}
