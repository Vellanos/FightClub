<?php

namespace App\Controller;

use App\Message\SimMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

date_default_timezone_set('Europe/Paris');

class BetController extends AbstractController
{
    #[Route('/sim', name: 'app_sim')]
    public function index(MessageBusInterface $bus): Response
    {

        $bus->dispatch(new SimMessage());

        return $this->redirectToRoute('app_home');
    }
}
