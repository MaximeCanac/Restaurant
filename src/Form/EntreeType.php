<?php
// src/Form/EntreeType.php

namespace App\Form;

use App\Entity\Entree;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\ORM\EntityManagerInterface;

class EntreeType extends AbstractType
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
                'label' => 'Nom de l\'entrée',
                'required' => true,
                'constraints' => [
                    new Callback([$this, 'validateUniqueEntree']),
                ],
            ])
            ->add('ingredient', TextType::class, [
                'label' => 'Ingrédient de l\'entrée',
                'required' => true,
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prix de l\'entrée',
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
            'data_class' => Entree::class,
        ]);
    }

    public function validateUniqueEntree($nom, ExecutionContextInterface $context)
    {
        $existingEntree = $this->entityManager->getRepository(Entree::class)->findOneBy(['nom' => $nom]);

        if ($existingEntree) {
            $context->buildViolation('Cette entrée existe déjà.')
                ->atPath('nom')
                ->addViolation();
        }
    }
}
