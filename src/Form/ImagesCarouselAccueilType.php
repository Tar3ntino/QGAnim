<?php

namespace App\Form;

use App\Entity\ImagesCarouselAccueil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ImagesCarouselAccueilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // On ajoute le champ "images" dans le formulaire
            // Il n'est pas lié à la Base De Données (mapped à false)
            ->add('images', FileType::class, [
                'label' => "Ajouter une nouvelle image au carousel",
                'multiple' => false,
                'mapped' => false,  
                // Si on passe "mapped" à true, le formulaire va chercher ce champ dans 
                // la table et ne va pas le trouver donc renvoyer une erreur
                'required' => true
            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImagesCarouselAccueil::class,
        ]);
    }
}