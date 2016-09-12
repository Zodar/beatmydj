<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StyleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('deep',null,['label' => 'Deep'])
            ->add('electro',null,['label' => 'Electro'])
            ->add('house',null,['label' => 'House'])
            ->add('years80',null,['label' => 'Années 80'])
            ->add('years90',null,['label' => 'Années 90'])
            ->add('disco',null,['label' => 'Disco'])
            ->add('rock',null,['label' => 'Rock'])
            ->add('dance',null,['label' => 'Dance'])
            ->add('hiphop',null,['label' => 'HipHop'])
            ->add('reggae',null,['label' => 'Reggea'])
            ->add('rnb',null,['label' => 'Rnb'])
            ->add('latino',null,['label' => 'Latino'])
            ->add('funk',null,['label' => 'Funk'])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Style'
        ));
    }
}
