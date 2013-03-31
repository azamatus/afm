<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\NewsBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Sonata\NewsBundle\Form\Type\CommentType as BaseType;

class CommentType extends BaseType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('message', 'textarea', array('label'=>"Сообщение"))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'app_sonata_post_comment';
    }
}
