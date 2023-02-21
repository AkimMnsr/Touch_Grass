<?php

namespace App\Controller\Admin;

use App\Entity\Sorties;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
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


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            DateField::new('datedebut'),
            TimeField::new('duree'),
            DateField::new('datecloture'),
            NumberField::new('nbinscriptionsmax'),
            TextEditorField::new('descriptioninfos'),
            TextField::new('urlphoto'),
            AssociationField::new('lieux_no_lieu'),
            TextField::new('etatsortie'),
            AssociationField::new('organisateur'),
            AssociationField::new('etats_no_etat'),
            AssociationField::new('id_inscription')
        ];
    }

}
