<?php

namespace App\Controller;

use App\Entity\Fighter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

date_default_timezone_set('Europe/Paris');

class FighterController extends AbstractController
{
    #[Route('/fighter', name: 'app_fighter')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $fighterRepository = $entityManager->getRepository(Fighter::class);
        $fighters = $fighterRepository->findAll();

        return $this->render('fighter/index.html.twig', [
            'fighters' => $fighters,
        ]);
    }

    #[Route('/fighter/{id}', name: 'app_fighter_details')]
    public function fighterDetails($id, EntityManagerInterface $entityManager): Response
    {
        $fighterRepository = $entityManager->getRepository(Fighter::class);
        $fighter = $fighterRepository->findOneBy(['id' => $id]);

        if (!$fighter) {
            return $this->redirectToRoute('app_fighter');
        }

        

        return $this->render('fighter/details.html.twig', [
            'fighter' => $fighter,
        ]);
    }
}
