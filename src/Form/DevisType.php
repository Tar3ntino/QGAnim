<?php

namespace App\Form;

use App\Entity\Devis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address')
            ->add('date_Of_Issue')
            ->add('expiration_Date')
            ->add('description')
            ->add('quantity')
            ->add('unit_Price')
            ->add('tax')
            ->add('amount')
            ->add('demande')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}