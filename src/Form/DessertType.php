<?php
// src/Form/DessertType.php

namespace App\Form;

use App\Entity\Dessert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DessertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du dessert',
                'required' => true,
            ])
            ->add('ingredient', TextType::class, [
                'label' => 'Ingrédient du dessert',
                'required' => true,
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prix du dessert',
                'required' => true,
                'scale' => 2,
                'attr' => [
                    'min' => 0,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dessert::class,
        ]);
    }
}