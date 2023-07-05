<?php

namespace App\Controller\Admin;

use App\Entity\Cars;
use App\Entity\Details;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
        public function index(): Response
    {
        /*return parent::index();*/

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
//         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
//         return $this->redirect($adminUrlGenerator->setController(CarsCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
//         if (!in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
//             return $this->redirect('/');
//         }
//             $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
//             return $this->redirect($adminUrlGenerator->setController(CarsCrudController::class)->generateUrl());

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        if (!in_array(['ROLE_ADMIN', 'ROLE_USER'], $this->getUser()->getRoles())) {
            return $this->render('dashBoard/dashBoard.html.twig');
        }
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Garage V Parrot')
            ->renderContentMaximized()
            ;
    }

    public function configureMenuItems(): iterable
    {
//        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::linkToRoute('Back to the website', 'fa-solid fa-house', 'app_home_index');
        yield MenuItem::linkToCrud('Cars', 'fa-solid fa-car', Cars::class);
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            yield MenuItem::linkToCrud('Employees', 'fa-solid fa-users', User::class);
        }
        yield MenuItem::linkToCrud('Informations', 'fa-solid fa-circle-info', Details::class)
            ->setAction('edit')
            ->setEntityId(1)
        ;


    }
}
