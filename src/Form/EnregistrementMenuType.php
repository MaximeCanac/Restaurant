<?php
// src/Form/EnregistrementMenuType.php
namespace App\Form;

use App\Entity\Plats;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnregistrementMenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entrees', ChoiceType::class, [
                'choices' => $options['plats'],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('plats', ChoiceType::class, [
                'choices' => $options['plats'],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('desserts', ChoiceType::class, [
                'choices' => $options['plats'],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Afficher les plats'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Plats::class,
            'plats' => [],
        ]);
    }
}
