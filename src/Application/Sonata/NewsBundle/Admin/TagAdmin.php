<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\NewsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\NewsBundle\Admin\TagAdmin as BaseAdmin;

class TagAdmin extends BaseAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('slug', null, array('editable' => true,'template'=>'StrokitCoreBundle:Admin:edit_integer.html.twig'))
            ->add('enabled', null, array('editable' => true))
        ;
    }

    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'StrokitCoreBundle:Admin:base_layout.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    public function isAclEnabled()
    {
        return false;
    }
}
