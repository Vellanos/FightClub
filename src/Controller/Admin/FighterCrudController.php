<?php

namespace App\Controller\Admin;

use App\Entity\Fighter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class FighterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Fighter::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('lastname'),
            TextField::new('firstname'),
            TextField::new('pseudo'),
            IntegerField::new('level'),
            IntegerField::new('victory'),
            IntegerField::new('defeat'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('imageName')->setBasePath('/pictures')->setUploadDir('/public')->hideOnForm(),
        ];
    }
    
}
