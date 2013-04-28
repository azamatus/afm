<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Admin
 * Date: 27.01.13
 * Time: 14:08
 * To change this template use File | Settings | File Templates.
 */
namespace Nurix\SliderBundle\Entity;

use Doctrine\ORM\EntityRepository;

class SliderRepository extends EntityRepository
{
    public function updateOrders($position, $element_id)
    {
            $query = $this->getEntityManager()
                ->createQueryBuilder()
                ->update('Nurix\SliderBundle\Entity\Slider', 's')
                ->set("s.sliderOrder", "s.sliderOrder + 1")
                ->where("s.sliderOrder >= :position")
                ->andWhere("s.id <> :element_id")
                ->setParameter("position", $position)
                ->setParameter("element_id", $element_id)
                ->getQuery()->execute();
    }
}