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
            ->add('images', FileType::class, [
                'label' => "Aperçu des images de présentation :",
                'multiple' => true,
                'mapped' => false,  
                'required' => false
            ])
            ->add('topDescription', CKEditorType::class)
            ->add('bottomDescription', CKEditorType::class)
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
