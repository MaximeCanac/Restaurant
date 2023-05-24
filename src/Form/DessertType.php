<?php
// src/Form/DessertType.php

namespace App\Form;

use App\Entity\Dessert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\ORM\EntityManagerInterface;

class DessertType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du dessert',
                'required' => true,
                'constraints' => [
                    new Callback([$this, 'validateUniqueDessert']),
                ],
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

    public function validateUniqueDessert($nom, ExecutionContextInterface $context)
    {
        $existingDessert = $this->entityManager->getRepository(Dessert::class)->findOneBy(['nom' => $nom]);

        if ($existingDessert) {
            $context->buildViolation('Ce dessert existe déjà.')
                ->atPath('nom')
                ->addViolation();
        }
    }
}