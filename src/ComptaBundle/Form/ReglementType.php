<?php

// src/ComptaBundle/Form/ReglementType.php
namespace ComptaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ReglementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numerochq')
            ->add('emetteur')
            ->add('banque')
            ->add('montant')
            ->add('modereg', ChoiceType::class, array(
    'choices' => array(
        'chèque' => 'chèque',
        'virement' => 'virement',
        'mandat' => 'mandat',
    ),
    'required'    => false,
    'placeholder' => '',
    'empty_data'  => null
    ))
            ->add('uploadscan', FileType::class, array('label' => 'Uploadscan'
    ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ComptaBundle\Entity\Reglement',
        ));
    }
}