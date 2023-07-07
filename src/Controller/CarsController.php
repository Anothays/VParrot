<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Form\CarsType;
use App\Repository\CarsRepository;
use App\Repository\DetailsRepository;
use App\Service\ImageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cars')]
class CarsController extends AbstractController
{
    #[Route('/', name: 'app_cars_index', methods: ['GET'])]
    public function index(CarsRepository $carsRepository, Request $request): Response
    {
        $MinMaxValues = $carsRepository->createQueryBuilder('m')
            ->select('MAX(m.mileage) as maxMileage, Min(m.mileage) as minMileage, MAX(m.price) as maxPrice, Min(m.price) as minPrice, MAX(m.registrationYear) as maxYear, MIN(m.registrationYear) as minYear')
            ->getQuery()
            ->getResult();
        if ($request->get('ajax')) {
            $params = [
                'mileageMin' => $request->get('mileage-min'),
                'mileageMax' => $request->get('mileage-max'),
                'priceMin' => $request->get('price-min'),
                'priceMax' => $request->get('price-max'),
                'yearMin' => $request->get('year-min'),
                'yearMax' => $request->get('year-max')
            ];
            $cars = $carsRepository->findByFilters($params);
            return $this->json([
                'content' => $this->render('cars/cars_list_item.html.twig', ['cars' => $cars, 'MinMaxValues' => $MinMaxValues[0]]),
                'contentLength' => count($cars),
            ]);
        }
        return $this->render('cars/index.html.twig', [
            'cars' => $carsRepository->findAll(),
            'MinMaxValues' => $MinMaxValues[0]
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

    #[Route('/{id}', name: 'app_cars_show', methods: ['GET'])]
    public function show(Cars $car, DetailsRepository $scheduleRepository): Response
    {
        return $this->render('cars/show.html.twig', [
            'car' => $car,
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
