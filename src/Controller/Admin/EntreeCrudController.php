<?php

namespace App\Controller\Admin;

use App\Entity\Entree;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EntreeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Entree::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
