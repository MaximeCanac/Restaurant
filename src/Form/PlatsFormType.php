<?php

namespace App\Form;

use App\Entity\Plats;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlatsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entrees', EntityType::class, [
                'class' => Plats::class,
                'choices' => $options['plats'],
                'multiple' => true,
                'expanded' => true,
                'label' => 'Choisissez 3 entrées'
            ])
            ->add('plats', EntityType::class, [
                'class' => Plats::class,
                'choices' => $options['plats'],
                'multiple' => true,
                'expanded' => true,
                'label' => 'Choisissez 3 plats'
            ])
            ->add('desserts', EntityType::class, [
                'class' => Plats::class,
                'choices' => $options['plats'],
                'multiple' => true,
                'expanded' => true,
                'label' => 'Choisissez 3 desserts'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['plats']);
        $resolver->setAllowedTypes('plats', 'array');
    }
}
