<?php

// src/DocumentBundle/Form/ProductType.php
namespace DocumentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('contenu')
            ->add('type', ChoiceType::class, array(
    'choices' => array(
        'formation' => 'formation',
        'projet site' => 'projet site',
        'prestation' => 'prestation',
        'autre' => 'autre',
    ),
    'required'    => false,
    'placeholder' => '',
    'empty_data'  => null
    ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DocumentBundle\Entity\Product',
        ));
    }
}