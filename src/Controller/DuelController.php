<?php

namespace App\Controller;

use App\Entity\Bet;
use App\Entity\Duel;
use App\Entity\Fighter;
use App\Entity\User;
use App\Form\BetFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security as SecurityBundleSecurity;
use Symfony\Component\HttpFoundation\Request;

class DuelController extends AbstractController
{
    #[Route('/duel/{id}', name: 'app_duel')]
    public function index($id, EntityManagerInterface $entityManager, SecurityBundleSecurity $security): Response
    {
        $duelRepository = $entityManager->getRepository(Duel::class);
        $duel = $duelRepository->find($id);

        $cotes = [];

            $fighter1 = $duel->getFighter1();
            $level_1 = $fighter1->getLevel();

            $fighter2 = $duel->getFighter2();
            $level_2 = $fighter2->getLevel();

            $cotes = $this->calculerCote($level_1, $level_2);

        if (!$duel || $duel->isStatus() == 0) {
            return $this->redirectToRoute('app_home');
        }

        if (!$security->getUser()) {
                return $this->redirectToRoute('app_login');
        }


        return $this->render('duel/index.html.twig', [
            'duel' => $duel,
            'cotes' => $cotes
        ]);
    }

    #[Route('/duel/{duel_id}/{fighter_id}', name: 'app_bet', priority:10)]
    public function betDuel($duel_id, $fighter_id, EntityManagerInterface $entityManager, Request $request, SecurityBundleSecurity $security): Response
    {
        $duelRepository = $entityManager->getRepository(Duel::class);
        $duel = $duelRepository->find($duel_id);

        $fighterRepository = $entityManager->getRepository(Fighter::class);
        $fighter = $fighterRepository->find($fighter_id);

        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->find($this->getUser());

        if (!$duel || $duel->isStatus() == 0) {
            return $this->redirectToRoute('app_home');
        }

        if ($duel->getFighter1()->getId() != $fighter_id && $duel->getFighter2()->getId() != $fighter_id) {
            return $this->redirectToRoute('app_register');
        }

        if (!$security->getUser()) {
                return $this->redirectToRoute('app_login');
        }

        $bet = new Bet();

        $form = $this->createForm(BetFormType::class, $bet);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $bet->setBetValue($form['bet_value']->getData());
            $bet->setStatus(1);
            $bet->setDate(new \DateTime);
            $bet->setUser($this->getUser());
            $bet->setDuel($duel);
            $bet->setFighter($fighter);

            $user->setWallet($user->getWallet()-$form['bet_value']->getData());
            
            $entityManager->persist($bet);
            $entityManager->flush();
            return $this->redirectToRoute('app_profile', ['id' => $user->getId()]);
        }

        return $this->render('duel/bet.html.twig', [
            'duel' => $duel,
            'createForm' => $form,
            'user' => $user
        ]);
    }

}
