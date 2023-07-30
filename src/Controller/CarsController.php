<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Entity\Contact;
use App\Form\CarsType;
use App\Form\ContactType;
use App\Repository\CarsRepository;
use App\Repository\ContactRepository;
use App\Repository\DetailsRepository;
use App\Service\ImageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isEmpty;

#[Route('/cars')]
class CarsController extends AbstractController
{
    #[Route('/', name: 'app_cars_index', methods: ['GET', 'POST'])]
    public function index(CarsRepository $carsRepository, Request $request, ContactRepository $contactRepository): Response
    {
        // Création du formulaire
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        // Récupération des valeurs minimum et maximum pour mileage, price, registrationYear
        $MinMaxValues = $carsRepository->createQueryBuilder('m')
            ->select('MAX(m.mileage) as maxMileage, Min(m.mileage) as minMileage, MAX(m.price) as maxPrice, Min(m.price) as minPrice, MAX(m.registrationYear) as maxYear, MIN(m.registrationYear) as minYear')
            ->getQuery()
            ->getResult();

        if ($request->get('ajax') === "1") {
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
//                'pagination' => $this->render('cars/pagination.html.twig', ['cars' => $cars]),
            ]);
//            switch ($request->get('ajaxAction')) {
//                case 'filters':
//                    $params = [
//                        'mileageMin' => $request->get('mileage-min') ?? $MinMaxValues[0]['minMileage'],
//                        'mileageMax' => $request->get('mileage-max') ?? $MinMaxValues[0]['maxMileage'],
//                        'priceMin' => $request->get('price-min') ?? $MinMaxValues[0]['minPrice'],
//                        'priceMax' => $request->get('price-max') ?? $MinMaxValues[0]['maxPrice'],
//                        'yearMin' => $request->get('year-min') ?? $MinMaxValues[0]['minYear'],
//                        'yearMax' => $request->get('year-max') ?? $MinMaxValues[0]['maxYear']
//                    ];
//                    $page = $request->get('page') ?? "1";
//                    $cars = $carsRepository->findByFilters($params, $page);
//                    return $this->json([
//                        'content' => $this->render('cars/cars_list_item.html.twig', ['cars' => $cars]),
//                        'contentCount' => $cars['count'],
//                        'pagination' => $this->render('cars/pagination.html.twig', ['cars' => $cars]),
//                    ]);
//
//                case 'pageChanged':
//                    $params = [
//                        'mileageMin' => $request->get('mileage-min') ?? $MinMaxValues[0]['minMileage'],
//                        'mileageMax' => $request->get('mileage-max') ?? $MinMaxValues[0]['maxMileage'],
//                        'priceMin' => $request->get('price-min') ?? $MinMaxValues[0]['minPrice'],
//                        'priceMax' => $request->get('price-max') ?? $MinMaxValues[0]['maxPrice'],
//                        'yearMin' => $request->get('year-min') ?? $MinMaxValues[0]['minYear'],
//                        'yearMax' => $request->get('year-max') ?? $MinMaxValues[0]['maxYear']
//                    ];
//                    $page = $request->get('page') ?? "1";
//                    $cars = $carsRepository->findByFilters($params, $page);
//                    return $this->json([
//                        'content' => $this->render('cars/cars_list_item.html.twig', ['cars' => $cars]),
//                        'contentCount' => $cars['count'],
//                        'pagination' => $this->render('cars/pagination.html.twig', ['cars' => $cars]),
//                    ]);
//            }
        }


        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->save($contact, true);
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

    #[Route('/new', name: 'app_cars_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CarsRepository $carsRepository, DetailsRepository $scheduleRepository, ImageService $imageService): Response
    {
        $car = new Cars();
        $form = $this->createForm(CarsType::class, $car);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('imageFile')->getData();
            if($image) {
//                dd($image[0]);
                $fichier = $imageService->add($image[0], null, 300,300);
                $car->setImageName($fichier);
            }
            $carsRepository->save($car, true);
            return $this->redirectToRoute('app_cars_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cars/new.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cars_show', methods: ['GET', 'POST'])]
    public function show(Cars $car, DetailsRepository $scheduleRepository, Request $request, ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
//            $this->addFlash(
//                'notice',
//                'Nous avons bien reçus votre message, nous reviendrons vers vous aussi vite que possible'
//            );
            $contactRepository->save($contact, true);
            return $this->json([
                'message' => 'Nous avons bien reçus votre message, nous reviendrons vers vous aussi vite que possible'
            ]);
        }
        return $this->render('cars/show.html.twig', [
            'id' => $car->getId(),
            'car' => $car,
            'form' => $form
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cars_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cars $car, CarsRepository $carsRepository, DetailsRepository $scheduleRepository, ImageService $imageService): Response
    {
        $form = $this->createForm(CarsType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('imageFile')->getData();
            if($image) {
                if($car->getImageName()) {
                    $imageService->delete($car->getImageName());
                }
                $fichier = $imageService->add($image[0], null, 300, 300);
                $car->setImageName($fichier);
            }
            $carsRepository->save($car, true);

            return $this->redirectToRoute('app_cars_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cars/edit.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cars_delete', methods: ['POST'])]
    public function delete(Request $request, Cars $car, CarsRepository $carsRepository, ImageService $imageService): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->request->get('_token'))) {
-            $carsRepository->remove($car, true);
            $imageService->delete($car->getImageName());

        }

        return $this->redirectToRoute('app_cars_index', [], Response::HTTP_SEE_OTHER);
    }
}
