<?php

namespace App\Controller\Admin;

use App\Entity\Sorties;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class SortiesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sorties::class;
    }


    public function configureFields(string $Sorties): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
            DateField::new('datedebut'),
            TimeField::new('duree'),
            DateField::new('datecloture'),
            NumberField::new('nbinscriptionsmax'),
            TextEditorField::new('descriptioninfos'),
            TextField::new('urlphoto'),
            TextField::new('etatsortie'),
            TextField::new('organisateur'),
        ];
    }

}
