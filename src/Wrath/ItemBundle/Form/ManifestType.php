<?php

namespace Wrath\ItemBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ManifestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('operation_id')
            ->add('user_id')
            ->add('line_items', 'collection', array(
                'type' => new LineItemType(),
                'allow_add' => true,
                'by_reference' => false,
            ));
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wrath\ItemBundle\Entity\Manifest'
        ));
    }

    public function getName()
    {
        return 'wrath_itembundle_manifesttype';
    }
}
