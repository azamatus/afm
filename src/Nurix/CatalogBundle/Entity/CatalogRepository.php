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

}
