<?php
// src/Form/SelectionType.php
namespace App\Form;


use App\Entity\Plats;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\PlatsRepository;


class SelectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entrees', EntityType::class, [
                'class' => Plats::class,
                'query_builder' => function (PlatsRepository $repo) {
                    return $repo->createQueryBuilder('p')
                        ->andWhere('p.type = :type')
                        ->setParameter('type', 'entree')
                        ->orderBy('p.nom', 'ASC');
                },
                'multiple' => true,
                'expanded' => false,
                'placeholder' => 'Choisissez une entrée',
            ])
            ->add('plats', EntityType::class, [
                'class' => Plats::class,
                'query_builder' => function (PlatsRepository $repo) {
                    return $repo->createQueryBuilder('p')
                        ->andWhere('p.type = :type')
                        ->setParameter('type', 'plat')
                        ->orderBy('p.nom', 'ASC');
                },
                'multiple' => true,
                'expanded' => false,
                'placeholder' => 'Choisissez un plat principal',
            ])
            ->add('desserts', EntityType::class, [
                'class' => Plats::class,
                'query_builder' => function (PlatsRepository $repo) {
                    return $repo->createQueryBuilder('p')
                        ->andWhere('p.type = :type')
                        ->setParameter('type', 'dessert')
                        ->orderBy('p.nom', 'ASC');
                },
                'multiple' => true,
                'expanded' => false,
                'placeholder' => 'Choisissez un dessert',
            ])
            ->add('submit', SubmitType::class, ['label' => 'Sélectionner'])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // configure your form options here
        ]);
    }
}
