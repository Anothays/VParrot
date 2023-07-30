<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Entity\Photos;
use App\Entity\Testimonials;
use App\Form\TestimonialType;
use App\Repository\DetailsRepository;
use App\Repository\ServicesRepository;
use App\Repository\TestimonialsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    public function __construct(public ParameterBagInterface $parameterBag)
    {

    }

    #[Route('/', name: 'app_home_index', methods: ['GET', 'POST'])]
    public function index(Request $request, TestimonialsRepository $testimonialsRepository, ServicesRepository $servicesRepository, DetailsRepository $detailsRepository): Response
    {
        $testimonials = new Testimonials();
        $form = $this->createForm(TestimonialType::class, $testimonials);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $testimonials->setValidated(false);
            $testimonialsRepository->save($testimonials, true);
            return $this->json([
                'message' => 'Merci pour votre avis !'
            ]);
        }

        if ($request->get('ajax') === "1") {
            $page = $request->get('page');
            return $this->json($testimonialsRepository->findTestimonialsPaginated($page,10));
        }

        return $this->render('home/index.html.twig', [
            'form' => $form,
            'details' => $detailsRepository->find(1),
            'testimonials' => $testimonialsRepository->findBy(["validated" => "1"],["createdAt" => "DESC"], 5, 0),
            'services' => $servicesRepository->findAll(),
        ]);
    }

//    #[Route('/test', name: 'app_home_test', methods: ['GET', 'POST'])]
//    public function test(): Response
//    {
//        return $this->render('test.html.twig');
//    }
}
