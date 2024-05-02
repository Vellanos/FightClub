<?php

namespace App\MessageHandler;

use App\Entity\Bet;
use App\Entity\Duel;
use App\Entity\Fighter;
use App\Entity\User;
use App\Message\SimMessage;
use App\Service\DuelService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class SimMessageHandler
{

    private $duelService;

    public function __construct(private EntityManagerInterface $entityManager, DuelService $duelService)
    {
        $this->duelService = $duelService;
    }

    public function __invoke(SimMessage $message)
    {
        $duelRepository = $this->entityManager->getRepository(Duel::class);
        $activeDuel = $duelRepository->findBy(['status' => 1]);

        $betRepository = $this->entityManager->getRepository(Bet::class);

        $fighterRepository = $this->entityManager->getRepository(Fighter::class);

        $userRepository = $this->entityManager->getRepository(User::class);

        $duelsId = [];
        $fightersId = [];
        $cotes = [];
        $sims = [];

        foreach ($activeDuel as $index => $duel) {

            $duelId = $duel->getId();

            $fighter1 = $duel->getFighter1();
            $level_1 = $fighter1->getLevel();
            $fighter1Id = $fighter1->getId();

            $fighter2 = $duel->getFighter2();
            $level_2 = $fighter2->getLevel();
            $fighter2Id = $fighter2->getId();

            $duelsId[$index] = $duelId;
            $fightersId[$index] = [$fighter1Id, $fighter2Id];
            $cotes[$index] = $this->duelService->calculerCote($level_1, $level_2);
            $sims[$index] = $this->duelService->simulationFight($this->duelService->returnProba($level_1, $level_2)[0], $fighter1Id, $fighter2Id);
        }

        for ($i = 0; $i < 7; $i++) {
            if ($sims[$i] == $fightersId[$i][0]) {
                $fighterWin = $fighterRepository->findOneBy(['id' => $fightersId[$i][0]]);
                $fighterLoose = $fighterRepository->findOneBy(['id' => $fightersId[$i][1]]);

                $coteIndex = 0;
            } else {
                $fighterWin = $fighterRepository->findOneBy(['id' => $fightersId[$i][1]]);
                $fighterLoose = $fighterRepository->findOneBy(['id' => $fightersId[$i][0]]);
                $coteIndex = 1;
            }

            $oldFighterLevelWin = $fighterWin->getLevel();
            $oldFighterLevelLoose = $fighterLoose->getLevel();
            if ($oldFighterLevelWin < 20) {
                $fighterWin->setLevel($oldFighterLevelWin + 1);
            }
            if ($oldFighterLevelLoose > 1) {
                $fighterLoose->setLevel($oldFighterLevelLoose - 1);
            }
            $fighterWin->setVictory($fighterWin->getVictory() + 1);
            $this->entityManager->persist($fighterWin);
            $fighterLoose->setDefeat($fighterLoose->getDefeat() + 1);
            $this->entityManager->persist($fighterLoose);


            $betGain = $betRepository->findBy(['duel' => $duelsId[$i]]);

            for ($j = 0; $j < count($betGain); $j++) {
                if ($betGain[$j]->getFighter() == $fighterWin) {
                    $betGain[$j]->setGain($betGain[$j]->getBetValue() * $cotes[$i][$coteIndex]);

                    $user = $userRepository->findOneBy(['id' => $betGain[$j]->getUser()]);
                    $user->setWallet($user->getWallet() + ($betGain[$j]->getBetValue() * $cotes[$i][$coteIndex]));

                    $this->entityManager->persist($user);
                    $this->entityManager->flush();
                } else {
                    $betGain[$j]->setGain(0);
                }
                $betGain[$j]->setStatus(0);
                $this->entityManager->persist($betGain[$j]);
            }

            $duel = $duelRepository->findOneBy(['id' => $duelsId[$i]]);
            $duel->setStatus(0);
            $this->entityManager->persist($duel);
            $this->entityManager->flush();
        }

        $fighters = $fighterRepository->findAll();
        shuffle($fighters);

        for ($i = 0; $i < 14; $i += 2) {
            $newDuel = new Duel();

            $date = new \DateTime();
            $date->modify('+5 minutes');
            $newDuel->setDate($date);
            $newDuel->setPicture('duel' . rand(1, 5) . 'png');
            $newDuel->setStatus(1);
            $newDuel->setFighter1($fighters[$i]);
            $newDuel->setFighter2($fighters[$i + 1]);

            $this->entityManager->persist($newDuel);
            $this->entityManager->flush();
        }
    }

    
}
