<?php

namespace App\Controller\Admin;

use App\Entity\Bet;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class BetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bet::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('user', 'User')->autocomplete(),
            AssociationField::new('duel', 'Duel')->autocomplete(),
            AssociationField::new('fighter', 'Fighter')->autocomplete(),
            NumberField::new('bet_value'),
            BooleanField::new('status'),
            NumberField::new('gain')->hideOnForm(),
            DateTimeField::new('date')->setFormat('yyyy-MM-dd HH:mm:ss'),
        ];
    }
}


