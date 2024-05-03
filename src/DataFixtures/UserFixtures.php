<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

date_default_timezone_set('Europe/Paris');

class UserFixtures extends AbstractFixtures
{

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("davidbak38@gmail.com");
        $user->setRoles(["ROLE_ADMIN"]);
        $password = $this->passwordHasher->hashPassword($user, '12345678');
        $user->setPassword($password);
        $user->setLastname("BAKALARZ");
        $user->setFirstname("David");
        $user->setPseudo("Vellanos");
        $user->setWallet(999999);

        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setEmail("davidbak38@gmail.fr");
        $user->setRoles(["ROLE_USER"]);
        $password = $this->passwordHasher->hashPassword($user, '12345678');
        $user->setPassword($password);
        $user->setLastname("BAKALARZ");
        $user->setFirstname("David");
        $user->setPseudo("Velauser");
        $user->setWallet(20);

        $manager->persist($user);
        $manager->flush();


        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email());
            $user->setRoles(["ROLE_USER"]);
            $password = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($password);
            $user->setLastname($this->faker->lastName());
            $user->setFirstname($this->faker->firstName());
            $user->setPseudo($this->faker->userName());
            $user->setWallet(0);

            $manager->persist($user);

            $this->setReference('user_' . $i, $user);
        }

        $manager->flush();
    }
}
