<?php

namespace App\Controller;

use App\Entity\Fighter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
}
