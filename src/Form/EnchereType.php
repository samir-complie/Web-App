<?php

namespace App\Form;

use App\Entity\Agriculteur;
use App\Entity\Enchere;
use App\Entity\ProduitEnchere;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnchereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('derniere_prix')
            ->add('date', null, [
                'widget' => 'single_text'
            ])
          
            ->add('id_agriculteur', EntityType::class, [
                'class' => Agriculteur::class,
'choice_label' => 'id',
            ])
            ->add('id_Produit_enchere', EntityType::class, [
                'class' => ProduitEnchere::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Enchere::class,
        ]);
    }
}
