<?php

namespace App\Form;

use App\Entity\Livraison;
use App\Entity\Transporteur;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;




class LivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etat_livraison',ChoiceType::class,[
                'choices' => [
                    'Livrée' => 'Livrée',
                    'Non Livrée' => 'Non Livrée',
                ],
                'expanded' => false,
                'multiple' => false,
                'placeholder' => 'Sélectionner un état',
                'required' => true,
            ]) 
            

          

     
            
            ->add('date_livraison', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'html5' => true,
                'label' => 'Date de Livraison',
                'constraints' => [
                    new Assert\NotBlank(message: 'Veuillez sélectionner une date de livraison.'),
                    new Assert\GreaterThanOrEqual([
                        'value' => new \DateTime('today'),
                        'message' => 'La date de livraison ne peut pas être dans le passé'
                    ])
                ]
            ])
            
            
            
            
            ->add('transporteur', EntityType::class, [
                'class' => Transporteur::class,
                'choice_label' => function (Transporteur $transporteur){
                    return $transporteur->getNom(). ' ' . $transporteur->getPrenom();
                },
                'placeholder' => 'Sélectionner un transporteur',
                'required' => false,
            ])
            ->add('voiture', EntityType::class, [
                'class' => Voiture::class,
                'choice_label' => 'matricule',
                'placeholder' => 'Sélectionner une voiture',
                'required' => true,

            ]);

            
        
        }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livraison::class,
        ]);
    }
}
