<?php

namespace App\Form;

use App\Entity\Agriculteur;
use App\Entity\Categorie;
use App\Entity\ProduitEnchere;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProduitEnchereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomP')
            ->add('description')
            ->add('quantie')
            ->add('prixF', NumberType::class, [
                'required' => false,
                'empty_data' => null,
            ])
            ->add('prixI')
            ->add('path_img')
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
