<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Application\Sonata\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Sonata\UserBundle\Form\Type\ProfileType as BaseType;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileType extends BaseType
{

    /**
     * @param string $class The User class name
     */
    public function __construct($class)
    {
		parent::__construct($class);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		parent::buildForm($builder,$options);
        $builder
            ->add('address', null, array('required' => false))
        ;
    }
}
