<?php

namespace Wrath\ItemBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LineItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('item', 'entity', array(
                'class' => 'WrathItemBundle:Item',
                'property' => 'name',
            ))
            ->add('quantity')
            //->add('current_value')
            //->add('manifest')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wrath\ItemBundle\Entity\LineItem'
        ));
    }

    public function getName()
    {
        return 'wrath_itembundle_lineitemtype';
    }
}
