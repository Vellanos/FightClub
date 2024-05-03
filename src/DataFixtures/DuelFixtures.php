<?php

namespace App\DataFixtures;

use App\Entity\Duel;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

date_default_timezone_set('Europe/Paris');

class DuelFixtures extends AbstractFixtures implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $duelCount = 0;

        for ($i = 0; $i < 14; $i += 2) {
            $duel = new Duel();

            $fighter1 = $this->getReference('fighter_' . $i);
            $fighter2 = $this->getReference('fighter_' . $i + 1);

            // while ($fighter1 == $fighter2) {
            //     $fighter1 = $this->getReference('fighter_' . $this->faker->numberBetween(0, 13));
            //     $fighter2 = $this->getReference('fighter_' . $this->faker->numberBetween(0, 13));
            // }

            $duel->setFighter1($fighter1);
            $duel->setFighter2($fighter2);
            $duel->setDate(new \DateTime());
            $duel->setStatus(1);

            $manager->persist($duel);

            $this->setReference('duel_' . $duelCount, $duel);

            $duelCount = $duelCount + 1;
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
