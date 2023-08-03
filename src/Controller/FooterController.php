<?php

namespace App\Controller;

use App\Repository\EstablishmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{

    public function index(EstablishmentRepository $detailRepository): Response
    {
        return $this->render('footer.html.twig', [
            'details' => $detailRepository->findAll()[0],
        ]);
    }
}
