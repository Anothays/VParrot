<?php

namespace App\Controller;

use App\Repository\GarageRepository;
use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FooterController extends AbstractController
{
    public function index(GarageRepository $garageRepository, ScheduleRepository $scheduleRepository): Response
    {
        $garage = $garageRepository->findAll()[0] ?? null;
        $schedule = $scheduleRepository->findAll()[0]?->getOpenedDays() ?? null;

        return $this->render('footer.html.twig', [
            'garage' => $garage,
            'schedule' => $schedule
        ]);
    }
}
