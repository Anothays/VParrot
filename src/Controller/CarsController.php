<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\ContactMessage;
use App\Form\ContactMessageType;
use App\Repository\CarRepository;
use App\Repository\ContactMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cars')]
class CarsController extends AbstractController
{

    #[Route('/', name: 'app_cars_index', methods: ['GET', 'POST'])]
    public function index(CarRepository $carsRepository, Request $request, ContactMessageRepository $contactMessageRepository): Response
    {
        // Création du formulaire
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contactMessage);
        $form->handleRequest($request);

        // Récupération des valeurs minimum et maximum pour mileage, price, registrationYear
        $MinMaxValues = $carsRepository->getMinMaxValues();

        // Gestion des filtres avec ajax
        if ($request->get('ajax') === "1") {
            return $this->handleAjaxFilters($request, $carsRepository, $MinMaxValues);
        }

        // Gestion soumission du formulaire de contact
        if ($form->isSubmitted() && $form->isValid()) {
            $contactMessageRepository->saveAndUpdateAssociatedCar($contactMessage, $carsRepository);
            return $this->json([
                'message' => 'Nous avons bien reçus votre message, nous reviendrons vers vous aussi vite que possible'
            ]);
        }
        $page = $request->get('page') ?? "1";
        return $this->render('cars/index.html.twig', [
            'cars' => $carsRepository->findCarsPaginated($page),
            'MinMaxValues' => $MinMaxValues[0],
            'form' => $form
        ]);
    }

    public function handleAjaxFilters(Request $request, CarRepository $carsRepository, $MinMaxValues) : JsonResponse
    {
        $params = [
            'mileageMin' => $request->get('mileage-min') ?? $MinMaxValues[0]['minMileage'],
            'mileageMax' => $request->get('mileage-max') ?? $MinMaxValues[0]['maxMileage'],
            'priceMin' => $request->get('price-min') ?? $MinMaxValues[0]['minPrice'],
            'priceMax' => $request->get('price-max') ?? $MinMaxValues[0]['maxPrice'],
            'yearMin' => $request->get('year-min') ?? $MinMaxValues[0]['minYear'],
            'yearMax' => $request->get('year-max') ?? $MinMaxValues[0]['maxYear']
        ];

        $page = $request->get('page') ?? "1";
        $selectPagination = $request->get('selectPagination') ?? "5";
        $cars = $carsRepository->findByFilters($params, $page, $selectPagination);
        return $this->json([
            'content' => $this->render('cars/cars_list_item.html.twig', ['cars' => $cars]),
            'contentCount' => $cars['count'],
            'pagination' => $this->render('cars/pagination_list.html.twig', ['cars' => $cars]),
        ]);

    }

    #[Route('/{id}', name: 'app_cars_show', methods: ['GET', 'POST'])]
    public function show(Car $car, Request $request, ContactMessageRepository $contactRepository): Response
    {
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contactMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->saveAndUpdateAssociatedCar($contactMessage, $car);
            return $this->json([
                'message' => 'Nous avons bien reçus votre message, nous reviendrons vers vous aussi vite que possible'
            ]);
        }

        return $this->render('cars/show.html.twig', [
            'car' => $car,
            'form' => $form
        ]);
    }

}
