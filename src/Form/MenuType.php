<?php
//src/Form/MenuType.php
namespace App\Form;

use App\Entity\Dessert;
use App\Entity\Entree;
use App\Entity\Menu;
use App\Entity\Plat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, [ // Ajoutez le champ FileType pour l'image
                'label' => 'Image',
                'required' => false, // Rendre le champ facultatif
                'mapped' => false, // Ne pas lier le champ à une propriété de l'entité Menu
            ])
            ->add('entrees', EntityType::class, [
                'class' => Entree::class,
                'multiple' => true,
                'expanded' => false,
                'label' => 'Choix des entrées'
            ])
            ->add('plats', EntityType::class, [
                'class' => Plat::class,
                'multiple' => true,
                'expanded' => false,
                'label' => 'Choix des plats'
            ])
            ->add('desserts', EntityType::class, [
                'class' => Dessert::class,
                'multiple' => true,
                'expanded' => false,
                'label' => 'Choix des desserts'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
