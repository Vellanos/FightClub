<?php

namespace App\Controller\Admin;

use App\Entity\Duel;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class DuelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Duel::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            DateTimeField::new('date', 'Date'),
            AssociationField::new('fighter_1', 'Fighter 1')->autocomplete(),
            AssociationField::new('fighter_2', 'Fighter 2')->autocomplete(),
            BooleanField::new('status'),
        ];
    }
}
