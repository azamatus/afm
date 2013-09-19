<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nurlan
 * Date: 11.09.13
 * Time: 14:29
 * To change this template use File | Settings | File Templates.
 */
namespace Nurix\CatalogBundle\Entity;

use Doctrine\ORM\EntityRepository;

class BinOrdersRepository extends EntityRepository
{
    public function GetClientOrders($id)
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT b FROM CatalogBundle:BinOrders b where b.binClient = $id")
            ->getResult();
        return $query;
    }
}