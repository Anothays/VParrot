<?php

namespace App\Controller;

use App\Repository\GarageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FooterController extends AbstractController
{
    public function index(GarageRepository $garageRepository): Response
    {
        $garage = $garageRepository->findAll()[0];
        $schedule = $garage->getSchedule()->getOpenedDays();
        return $this->render('footer.html.twig', [
            'garage' => $garage,
            'schedule' => $schedule
        ]);
    }
}
