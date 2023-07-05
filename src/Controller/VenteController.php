<?php

namespace App\Controller;

use App\Repository\CarsRepository;
use App\Repository\DetailsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VenteController extends AbstractController
{
    #[Route('/vente', name: 'app_vente')]
    public function index(CarsRepository $carsRepository, DetailsRepository $scheduleRepository): Response
    {


        return $this->render('vente/index.html.twig', [
            'controller_name' => 'VenteController',
            'cars' => $carsRepository->findAll(),
        ]);
    }
}
