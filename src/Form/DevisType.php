<?php

namespace App\Form;

use App\Entity\Demande;
use App\Entity\Devis;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Doctrine\Common\Collections\Expr\Value;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address', TextType::class,[
                'label'=> "Adresse :",
            ])
            ->add('date_Of_Issue', DateType::class,[
                'label'=> "Date d'émission :",
            ])
            ->add('expiration_Date', DateType::class,[
                'label'=> "Date d'expiration :",
            ])
            ->add('description', TextType::class,[
                'label'=> "Description :",
            ])
            ->add('quantity',IntegerType::class,[
                'label'=> "Quantité :",
            ])
            ->add('unit_Price',IntegerType::class,[
                'label'=> "Prix unitaire:",
            ])
            ->add('tax',IntegerType::class,[
                'label'=> "Taxe :",
            ])
            ->add('amount',TextType::class,[
                'label'=> "Montant :"
            ])
            ->add('Valider', SubmitType::class);
    }

    public function onPreSetData(FormEvent $event): void
    {
        $data = $event->getData();
        $form = $event->getForm();

        // dd($data, $form);
    
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}