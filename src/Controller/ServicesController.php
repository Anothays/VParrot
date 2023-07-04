<?php

namespace App\Controller;

use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServicesController extends AbstractController
{
    #[Route('/services', name: 'app_services')]
    public function index(ScheduleRepository $scheduleRepository): Response
    {
        return $this->render('services/index.html.twig', [
            'controller_name' => 'ServicesController',
            'horaires' => $scheduleRepository->findAll()
        ]);
    }
}
