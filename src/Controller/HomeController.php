<?php

namespace App\Controller;

use App\Entity\Duel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $duelRepository = $entityManager->getRepository(Duel::class);
        $duels = $duelRepository->findAll();

        $cotes = [];

        foreach ($duels as $index => $duel) {

            $fighter1 = $duel->getFighter1();
            $level_1 = $fighter1->getLevel();

            $fighter2 = $duel->getFighter2();
            $level_2 = $fighter2->getLevel();

            $cotes[$index] = calculerCote($level_1, $level_2);
        }

        return $this->render('home/index.html.twig', [
            'duels' => $duels,
            'cotes' => $cotes
        ]);
    }
}

function calculerCote($noteCombattant1, $noteCombattant2) {
    $probabilite1 = $noteCombattant1 / ($noteCombattant1 + $noteCombattant2);
    $probabilite2 = $noteCombattant2 / ($noteCombattant1 + $noteCombattant2);

    if ($noteCombattant1 == $noteCombattant2) {
        $probabilite1 = 0.5;
        $probabilite2 = 0.5;
    }

    $cote1 = round(1 / $probabilite1, 2);
    $cote2 = round(1 / $probabilite2, 2);

    return [$cote1, $cote2];
}

