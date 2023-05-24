<?php
// src/Form/PlatType.php

namespace App\Form;

use App\Entity\Plat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\ORM\EntityManagerInterface;

class PlatType extends AbstractType
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
                'label' => 'Nom du plat',
                'required' => true,
                'constraints' => [
                    new Callback([$this, 'validateUniquePlat']),
                ],
            ])
            ->add('ingredient', TextType::class, [
                'label' => 'Ingrédient du plat',
                'required' => true,
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prix du plat',
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
            'data_class' => Plat::class,
        ]);
    }
    public function validateUniquePlat($nom, ExecutionContextInterface $context)
    {
        $existingPlat = $this->entityManager->getRepository(Plat::class)->findOneBy(['nom' => $nom]);

        if ($existingPlat) {
            $context->buildViolation('Ce plat existe déjà.')
                ->atPath('nom')
                ->addViolation();
        }
    }
}
