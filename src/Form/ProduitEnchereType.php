<?php

namespace App\Form;

use App\Entity\Agriculteur;
use App\Entity\Categorie;
use App\Entity\ProduitEnchere;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitEnchereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('quantie')
            ->add('path_img')
            ->add('prixF')
            ->add('prixI')
            ->add('agriculteur', EntityType::class, [
                'class' => Agriculteur::class,
'choice_label' => 'id',
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProduitEnchere::class,
        ]);
    }
}
