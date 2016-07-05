<?php

// src/DocumentBundle/Form/DocumentType.php
namespace DocumentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference')
            ->add('datecreation', 'date')
            ->add('etat')
            ->add('nbreecheance')
            ->add('value')
            ->add('type', ChoiceType::class, array(
    'choices' => array(
        'devis' => 'devis',
        'facture' => 'facture',
        'avoir' => 'avoir',
        
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
            'data_class' => 'DocumentBundle\Entity\Documents',
        ));
    }
}