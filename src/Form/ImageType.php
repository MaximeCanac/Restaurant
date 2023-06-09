<?php

namespace App\Form;

use App\Entity\ImageMenu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('image', FileType::class, [ // Ajoutez le champ FileType pour l'image
            'label' => 'image',
            'required' => false, // Rendre le champ facultatif
            'mapped' => false, 
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ImageMenu::class,
        ]);
    }
}
