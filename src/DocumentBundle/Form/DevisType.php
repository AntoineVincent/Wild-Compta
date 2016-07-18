<?php

// src/DocumentBundle/Form/DevisType.php
namespace DocumentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use DocumentBundle\Entity\Documents;
use ClientBundle\Entity\Client;

class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('nom', EntityType::class, array(
                'class' => 'ClientBundle:Client'
            ))
            ->add('adresse', EntityType::class, array(
                'class' => 'ClientBundle:Client'
            ))*/
            ->add('type')
            ->add('reference')
            ->add('datecreation')
            ->add('tva');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DocumentBundle\Entity\Documents',
                'ClientBundle\Entity\Client'
        ));
    }
}