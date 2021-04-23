<?php

namespace App\Form;

use App\Entity\Animations;
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AnimationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,[
                'label' => 'Intitulé :'
            ])

            // On ajoute le champ "images" dans le formulaire
            // Il n'est pas lié à la Base De Données (mapped à false)
            ->add('images', FileType::class, [
                'label' => "Aperçu de l'animation :",
                'multiple' => true,
                'mapped' => false, 
                'required' => false
            ])
            ->add('scenario', CKEditorType::class,[
                'label' => 'Scenario :'
            ])
            ->add('technical_info', CKEditorType::class,[
                'label' => 'Caractéristiques techniques :'
            ])
            ->add('games', CKEditorType::class,[
                'label' => 'Jeux :'
            ])
            ->add('categories', EntityType::class,array(
                'class' => Categories::class,
                'multiple' => true, // nécessaire lorsque l'on a une relation many to many, car l'on précise que l'on peut accepter plusieurs catégories dans une variable tableau rattaché à une meme animation
                'label' => 'Catégorie :'
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
