<?php

namespace App\Controller\Admin;

use App\Entity\Participants;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ParticipantsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Participants::class;
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
