<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController implements EventSubscriberInterface
{
    protected UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    // Fonction de configuration des champs
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email'),
            TextField::new('lastname'),
            TextField::new('firstname'),
            TextField::new('pseudo'),
            IntegerField::new('wallet'),
            TextField::new('password')
            ->hideOnIndex()
            ->setFormType(PasswordType::class),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('imageName')->setBasePath('/pictures/user_picture')->setUploadDir('/public')->hideOnForm(),
        ];
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public static function getSubscribedEvents() {
        return [
            BeforeEntityPersistedEvent::class => ["hashPassword"]
        ];
    }

    public function hashPassword(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof User) {
            $plainPassword = $entity->getPassword();
            $hashedPassword = $this->passwordHasher->hashPassword($entity, $plainPassword);
            $entity->setPassword($hashedPassword);
            $entity->setRoles(["ROLE_USER"]);
        }
    }
}
