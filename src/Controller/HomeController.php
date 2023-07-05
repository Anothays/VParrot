<?php

namespace App\Controller;

use App\Repository\DetailsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home_index')]
    public function index(DetailsRepository $scheduleRepository): Response
    {
        return $this->render('home/index.html.twig', []);
    }
}
