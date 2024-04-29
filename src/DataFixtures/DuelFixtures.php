<?php

namespace App\DataFixtures;

use App\Entity\Duel;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DuelFixtures extends AbstractFixtures implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $picture = [
            "duel1.png",
            "duel2.png",
            "duel3.png",
            "duel4.png",
            "duel5.png"
        ];


        for ($i = 0; $i < 30; $i++) {
            $duel = new Duel();

            $fighter1 = $this->getReference('fighter_' . $this->faker->numberBetween(0, 13));
            $fighter2 = $this->getReference('fighter_' . $this->faker->numberBetween(0, 13));

            while ($fighter1 == $fighter2) {
                $fighter1 = $this->getReference('fighter_' . $this->faker->numberBetween(0, 13));
                $fighter2 = $this->getReference('fighter_' . $this->faker->numberBetween(0, 13));
            }

            $duel->setFighter1($fighter1);
            $duel->setFighter2($fighter2);
            $duel->setDate($this->faker->dateTimeBetween('+1 week', '+3 week'));
            $duel->setPicture($picture[$this->faker->numberBetween(0, 4)]);
            $duel->setStatus(1);

            $manager->persist($duel);

            $this->setReference('duel_' . $i, $duel);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            FighterFixtures::class,
        ];
    }
}
