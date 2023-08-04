<?php

namespace App\Controller;

use App\Repository\SocietyInfoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{

    public function index(SocietyInfoRepository $societyInfoRepository): Response
    {
        return $this->render('footer.html.twig', [
            'details' => $societyInfoRepository->find(1),
        ]);
    }
}
