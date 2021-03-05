<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('gender', ChoiceType::class, [
                'label'=>'Titre de civilité :',
                'choices'  => [
                    'Monsieur' => 'Mr',
                    'Madame' => 'Mme'
                ],
            ])
            ->add('firstname', TextType::class, array('label'=>'Prénom :',))
            ->add('name', TextType::class, array('label'=>'Nom :',))
            ->add('dateBirth', BirthdayType::class, [
                'label'=>'Date de naissance :',
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ]
            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}