<?php

namespace App\Controller;

use App\Entity\Bet;
use App\Entity\Duel;
use App\Entity\Fighter;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BetController extends AbstractController
{
    #[Route('/sim', name: 'app_sim')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $duelRepository = $entityManager->getRepository(Duel::class);
        $activeDuel = $duelRepository->findBy(['status' => 1]);

        $betRepository = $entityManager->getRepository(Bet::class);

        $fighterRepository = $entityManager->getRepository(Fighter::class);

        $userRepository = $entityManager->getRepository(User::class);

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

            $duelsId[$index] = $duelId; //USE
            $fightersId[$index] = [$fighter1Id, $fighter2Id]; //USE
            $cotes[$index] = $this->calculerCote($level_1, $level_2);
            $sims[$index] = $this->simulationFight($this->returnProba($level_1, $level_2)[0], $fighter1Id, $fighter2Id); //USE
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
            $entityManager->persist($fighterWin);
            $fighterLoose->setDefeat($fighterLoose->getDefeat() + 1);
            $entityManager->persist($fighterLoose);


            $betGain = $betRepository->findBy(['duel' => $duelsId[$i]]);

            for ($j = 0; $j < count($betGain); $j++) {
                if ($betGain[$j]->getFighter() == $fighterWin) {
                    $betGain[$j]->setGain($betGain[$j]->getBetValue() * $cotes[$i][$coteIndex]);

                    $user = $userRepository->findOneBy(['id' => $betGain[$j]->getUser()]);
                    $user->setWallet($user->getWallet() + ($betGain[$j]->getBetValue() * $cotes[$i][$coteIndex]));

                    $entityManager->persist($user);
                    $entityManager->flush();

                } else {
                    $betGain[$j]->setGain(0);
                }
                $betGain[$j]->setStatus(0);
                $entityManager->persist($betGain[$j]);
                
            }

            $duel = $duelRepository->findOneBy(['id' => $duelsId[$i]]);
            $duel->setStatus(0);
            $entityManager->persist($duel);
            $entityManager->flush();
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

            $entityManager->persist($newDuel);
            $entityManager->flush();
        }


        return $this->redirectToRoute('app_home');
    }
}
