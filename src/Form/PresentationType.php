<?php

namespace App\Form;

use App\Entity\Presentation;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PresentationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        // On ajoute le champ "images" dans le formulaire
            // Il n'est pas lié à la Base De Données (mapped à false)
            ->add('imageTop', FileType::class, [
                'label' => "Aperçu de l'image de présentation - Section Haut de Page :",
                'multiple' => false,
                'mapped' => false,  
                'required' => false
            ])
            ->add('topDescription', CKEditorType::class)
            ->add('bottomDescription', CKEditorType::class)
            ->add('imageBottom', FileType::class, [
                'label' => "Aperçu de l'image de présentation - Section Bas de Page :",
                'multiple' => false,
                'mapped' => false,  
                'required' => false
            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Presentation::class,
        ]);
    }
}