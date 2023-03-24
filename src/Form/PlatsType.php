<?php

use App\Entity\Plats;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class PlatType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entrees', CollectionType::class, [
                'entry_type' => ChoiceType::class,
                'entry_options' => [
                    'label' => false,
                    'choices' => $this->getPlatsByType('entree'),
                    'choice_label' => function(Plats $plats) {
                        return $plats->getNom() . ' (' . $plats->getPrix() . ' €)';
                    },
                    'multiple' => true,
                    'expanded' => true,
                ],
                'label' => 'Choisissez 3 entrées',
            ])
            ->add('plats', CollectionType::class, [
                'entry_type' => ChoiceType::class,
                'entry_options' => [
                    'label' => false,
                    'choices' => $this->getPlatsByType('plat'),
                    'choice_label' => function(Plats $plats) {
                        return $plats->getNom() . ' (' . $plats->getPrix() . ' €)';
                    },
                    'multiple' => true,
                    'expanded' => true,
                ],
                'label' => 'Choisissez 3 plats',
            ])
            ->add('desserts', CollectionType::class, [
                'entry_type' => ChoiceType::class,
                'entry_options' => [
                    'label' => false,
                    'choices' => $this->getPlatsByType('dessert'),
                    'choice_label' => function(Plats $plats) {
                        return $plats->getNom() . ' (' . $plats->getPrix() . ' €)';
                    },
                    'multiple' => true,
                    'expanded' => true,
                ],
                'label' => 'Choisissez 3 desserts',
            ]);
    }

    private function getPlatsByType(string $type): array
    {
        $plats = $this->em->getRepository(Plats::class)->findBy(['type' => $type]);
        $choices = [];
        foreach ($plats as $plat) {
            $choices[$plat->getNom()] = $plat;
        }
        return $choices;
    }
}

