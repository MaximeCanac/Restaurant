<?php
// src/Form/AjoutMenuType.php
namespace App\Form;

use App\Entity\Dessert;
use App\Entity\Entree;
use App\Entity\Plat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntreeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de l\'entrée',
                'required' => true,
            ])
            ->add('ingredient', TextType::class, [
                'label' => 'Ingrédients de l\'entrée',
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
}
class PlatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de l\'entrée',
                'required' => true,
            ])
            ->add('ingredient', TextType::class, [
                'label' => 'Ingrédients de l\'entrée',
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
            'data_class' => Plat::class,
        ]);
    }
}
class DessertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de l\'entrée',
                'required' => true,
            ])
            ->add('ingredient', TextType::class, [
                'label' => 'Ingrédients de l\'entrée',
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
            'data_class' => Dessert::class,
        ]);
    }
}