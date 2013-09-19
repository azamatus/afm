<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Aza
 * Date: 03.06.13
 * Time: 13:25
 * To change this template use File | Settings | File Templates.
 */

namespace Nurix\CatalogBundle\Entity;

use Doctrine\ORM\EntityRepository;



class ExchangeRepository  extends  EntityRepository{

    public function getRate($exchange){

            $em = $this->getEntityManager();
            $repository =$em -> getRepository('CatalogBundle:Exchange');
            $query = $repository ->createQueryBuilder('p')
                ->select('p')
                ->innerJoin("CatalogBundle:ExchangeHelper",'c','WITH','p.currency = c.id')
                ->where('c.currency = :v')
                ->setParameter('v', $exchange)
                ->orderBy('p.date','DESC')
                ->setMaxResults(1)
                ->getQuery();
            $rate = $query -> getOneOrNullResult();
            return $rate;
    }
}
