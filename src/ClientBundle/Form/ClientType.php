<?php

// src/ClientBundle/Form/ClientType.php
namespace ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idecole')
            ->add('nom')
            ->add('adresse')
            ->add('adressefactu')
            ->add('email')
            ->add('orgapayeur')
            ->add('bourse')
            ->add('telephonefixe')
            ->add('portable')
            ->add('type', ChoiceType::class, array(
    'choices' => array(
        'éléve' => 'élève',
        'projet site' => 'projet site',
        'kids' => 'kids',
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
            'data_class' => 'ClientBundle\Entity\Client',
        ));
    }
}