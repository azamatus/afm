<?php

namespace Nurix\CatalogBundle\Model;

use Doctrine\ORM\EntityManager;

class CatalogModel
{

    private $em;

    private $repository;

    public  function __construct( EntityManager $em)
    {
        $this->em = $em;

        $this->repository = $this->em->getRepository("CatalogBundle:Catalog");
    }
    public function getAll($rules = array()){
        $catalogs = $this->repository->createQueryBuilder('c');

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
