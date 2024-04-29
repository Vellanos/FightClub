<?php

namespace App\DataFixtures;

use App\Entity\Fighter;
use Doctrine\Persistence\ObjectManager;

class FighterFixtures extends AbstractFixtures
{

    public function load(ObjectManager $manager)
    {
        $lastName= [
            "WABENE MAYELE",
            "MADI ASSANI",
            "ORECCHIA",
            "MORON",
            "MOREAU",
            "FERREIRA",
            "LE CURIEUX-BELFOND",
            "RODRIGUES",
            "DRAPERI",
            "HEZIL",
            "BAKALARZ",
            "MARTIN",
            "WOLFF",
            "SCHWARTZ"
        ];

        $firstName= [
            "Cédric",
            "Orhan",
            "Damien",
            "Christopher",
            "Gaël",
            "Mathis",
            "Nicolas",
            "Joana",
            "Jasmine",
            "Lucas",
            "David",
            "Adam",
            "Kévin",
            "Cathrine"
        ];

        $pseudo= [
            "Le no lâcheur",
            "La dragon ball à Z",
            "The DuckMan",
            "Le pokémon",
            "El volcano",
            "La mascotte",
            "Coco le curieux",
            "L'abricot",
            "La fusée",
            "Lucastagne",
            "L'abeille",
            "Le vier de combat",
            "La turbomachine",
            "La patronne"
        ];

        $picture = [
            "cedric.png",
            "orhan.png",
            "damien.png",
            "christopher.png",
            "gael.png",
            "mathis.png",
            "nicolas.png",
            "joana.png",
            "jasmine.png",
            "lucas.png",
            "david.png",
            "adam.png",
            "kevin.png",
            "cathrine.png"
        ];

        for ($i = 0; $i < 14; $i++) {
            $fighter = new Fighter();
            $fighter->setLastname($lastName[$i]);
            $fighter->setFirstname($firstName[$i]);
            $fighter->setPseudo($pseudo[$i]);
            $fighter->setLevel($this->faker->numberBetween(1, 20));
            $fighter->setImageName($picture[$i]);
            $fighter->setUpdatedAt(new \DateTimeImmutable());
            $fighter->setVictory(0);
            $fighter->setDefeat(0);


            $manager->persist($fighter);
            $this->setReference('fighter_' . $i, $fighter);
        }

        $manager->flush();
    }
}
