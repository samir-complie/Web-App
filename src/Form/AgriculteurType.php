<?php

namespace App\Form;

use App\Entity\Agriculteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgriculteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('phone')
            ->add('RIB')
            ->add('nom')
            ->add('prenom')
            ->add('payment', NumberType::class, [
                'required' => false, // Ce champ n'est pas obligatoire
                'empty_data' => null, // Si rien n'est saisi, on met NULL
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agriculteur::class,
        ]);
    }
}
