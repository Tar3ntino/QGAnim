<?php

namespace App\Form;

use App\Entity\Demande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eventLocation', TextType::class,[
                'label'=> "Lieu / Ville de l'évènement :",
            ])
            ->add('numberPeople', IntegerType::class,[
                'label'=> "Nombre de personnes:",
            ])
            ->add('eventType', ChoiceType::class,  [
                'choices'  => [
                    'Anniversaire' => 'Anniversaire',
                    'Cours de guitare' => 'Cours de guitare',
                    'Entre amis' => 'Entre amis',
                    'EVG-EVJF' => 'EVG-EVJF',
                    'Maison de retraite' => 'Maison de retraite',
                    'Mariage' => 'Mariage',
                    'Live music' => 'Live music',
                    'Autres' => 'Autres',
                ],
                'label'=> "Type d'évènement:",
            ],)
            ->add('eventDate', DateType::class,[
                'label'=> "Date de l'évènement:",
            ])
            ->add('animationSchedules', TextType::class,[
                'label'=> "Horaires souhaités de l'animation (Ex: de 18h à minuit):",
            ])
            ->add('budgetClient', IntegerType::class,[
                'label'=> "Votre budget pour couvrir l'évènement: (€)",
            ])
            ->add('otherComments', TextType::class,[
                'label'=> "Quelque chose à rajouter ? - Préciser le contexte de cette animation, cela nous aidera à mieux cerner votre demande:",
            ])
            ->add('nameRequester', TextType::class,[
                'label'=> "Votre nom:",
            ])
            ->add('firstNameRequester', TextType::class,[
                'label'=> "Votre prénom:",
            ])
            ->add('nameCompanyOrAssociation', TextType::class,[
                'label'=> "Nom de votre entreprise / organisation / association (facultatif):",
                'required'   => false,
            ])
            ->add('emailRequester', TextType::class,[
                'label'=> "Email (Votre devis sera envoyé à cette adresse):",
            ])
            ->add('phoneRequester', TextType::class,[
                'label'=> "Numéro de téléphone:",
            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}