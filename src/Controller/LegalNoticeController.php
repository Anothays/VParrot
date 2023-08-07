<?php

namespace App\Controller;

use App\Repository\GarageRepository;
use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalNoticeController extends AbstractController
{
    #[Route('/mentions-legales', name: 'app_legal_notice')]
    public function index(GarageRepository $garageRepository): Response
    {
        return $this->render('legal_notice/index.html.twig', [
            'garage' => $garageRepository->findAll()[0]
        ]);
    }
}
