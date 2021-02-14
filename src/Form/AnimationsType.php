<?php

namespace App\Form;

use App\Entity\Animations;
use App\Entity\Categories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
 
class AnimationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('categories', EntityType::class,array(
                'class' => Categories::class,
                'multiple' => true // nécessaire lorsque l'on a une relation many to many, car l'on précise que l'on peut accepter plusieurs catégories dans une variable tableau rattaché à une meme animation
            ))
            ->add('Valider', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Animations::class,
        ]);
    }
}
