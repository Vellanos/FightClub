<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\DepotFormType;
use App\Form\ProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security as SecurityBundleSecurity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{

    #[Route('/profile/{id}', name: 'app_profile')]
    public function index($id, EntityManagerInterface $entityManager, SecurityBundleSecurity $security): Response
    {
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->find($id);

        if (!$user) {
            return $this->redirectToRoute('app_home');
        }

        if ($user !== $security->getUser()) {
            if (!$this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_home');
            }
        }


        return $this->render('profile/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profile/{id}/depot', name: 'app_profile_depot')]
    public function profileDepot($id, EntityManagerInterface $entityManager, SecurityBundleSecurity $security, Request $request): Response
    {
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->find($id);

        if (!$user) {
            return $this->redirectToRoute('app_home');
        }

        if ($user !== $security->getUser()) {
            if (!$this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_home');
            }
        }

        $form = $this->createForm(DepotFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUpdatedAt(new \DateTimeImmutable);

            $wallet = $user->getWallet();

            $user->setWallet($wallet + $form['wallet']->getData());

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_profile', ['id' => $user->getId()]);
        }

        return $this->render('profile/depot.html.twig', [
            'editForm' => $form,
            'user' => $user,
        ]);
    }

    #[Route('/profile/{id}/edit', name: 'app_profile_edit')]
    public function userEdit($id, EntityManagerInterface $entityManager,SecurityBundleSecurity $security, Request $request): Response
    {
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->find($id);

        if (!$user) {
            return $this->redirectToRoute('app_home');
        }

        if ($user !== $security->getUser()) {
            if (!$this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_home');
            }
        }

        $form = $this->createForm(ProfileFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUpdatedAt(new \DateTimeImmutable);

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_profile', ['id' => $user->getId()]);
        }

        return $this->render('profile/edit.html.twig', [
            'user' => $user,
            'editForm' => $form
        ]);
    }
}
