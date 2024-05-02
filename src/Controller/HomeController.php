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
        $duels = $duelRepository->findBy(['status' => 1]);

        $cotes = [];

        foreach ($duels as $index => $duel) {

            $fighter1 = $duel->getFighter1();
            $level_1 = $fighter1->getLevel();

            $fighter2 = $duel->getFighter2();
            $level_2 = $fighter2->getLevel();

            $cotes[$index] = $this->calculerCote($level_1, $level_2);
        }

        return $this->render('home/index.html.twig', [
            'duels' => $duels,
            'cotes' => $cotes
        ]);
    }
}

