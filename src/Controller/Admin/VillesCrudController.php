<?php

namespace App\Controller\Admin;

use App\Entity\Villes;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class VillesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Villes::class;
    }


   /* public function configureFields(string $Villes): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom_ville'),
            TextField::new('code_postal'),
        ];
    }
*/
}
