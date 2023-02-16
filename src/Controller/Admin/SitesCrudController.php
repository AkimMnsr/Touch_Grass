<?php

namespace App\Controller\Admin;

use App\Entity\Sites;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SitesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sites::class;
    }

    public function configureFields(string $sites): iterable
    {
        return [
            TextField::new('nom_site'),
        ];
    }

}
