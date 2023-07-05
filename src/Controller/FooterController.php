<?php

namespace App\Controller;

use App\Repository\DetailsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{
    #[Route('/footer', name: 'app_footer')]
    public function index(DetailsRepository $detailRepository): Response
    {
//        dd($detailRepository->findAll());
        return $this->render('footer.html.twig', [
            'details' => $detailRepository->findAll()[0],
        ]);
    }
}
