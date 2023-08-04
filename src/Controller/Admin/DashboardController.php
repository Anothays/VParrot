<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use App\Entity\ContactMessage;
use App\Entity\Establishment;
use App\Entity\Service;
use App\Entity\Testimonial;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
        public function index(): Response
    {
        /*return parent::index();*/

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(CarsCrudController::class)->generateUrl());

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
//        return $this->render('@EasyAdmin/page/content.html.twig');

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Espace Administrateur')
            ->setFaviconPath("/media/logo4.png")
            ->renderContentMaximized()
            ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Retour vers le site', 'fa-solid fa-house', 'app_home_index');
        yield MenuItem::linkToCrud('Véhicules', 'fa-solid fa-car', Car::class);
        yield MenuItem::linkToCrud('Demandes de contact', 'fa-solid fa-envelope', ContactMessage::class);
        yield MenuItem::linkToCrud('Avis', 'fa-regular fa-comment-dots', Testimonial::class);
        yield MenuItem::linkToCrud('Employés', 'fa-solid fa-users', User::class)
//            ->setPermission('ROLE_ADMIN')
        ;
        yield MenuItem::linkToCrud('Services', 'fa-solid fa-wrench', Service::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Établissements', 'fa-solid fa-circle-info',Establishment::class)->setPermission('ROLE_ADMIN')

        ;
//        yield MenuItem::linkToCrud('Informations', 'fa-solid fa-circle-info', Establishment::class)
//            ->setPermission('ROLE_ADMIN')
//            ->setAction(Action::EDIT)
//            ->setEntityId(1)
//        ;

    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->displayUserAvatar(false)
//            ->addMenuItems([
//                MenuItem::linkToRoute('Retour vers le site', 'fa-solid fa-house', 'app_home_index')
//            ])
        ;
    }

    public function configureActions(): Actions
    {
        return parent::configureActions();
    }

}
