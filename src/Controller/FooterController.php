<?php

namespace App\Controller;

use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{
    #[Route('/footer', name: 'app_footer')]
    public function index( ScheduleRepository $scheduleRepository): Response
    {
        return $this->render('footer.html.twig', [
            'horaires' => $scheduleRepository->findAll(),
        ]);
    }
}
