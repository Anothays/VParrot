<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use App\Entity\ContactMessage;
use App\Entity\Garage;
use App\Entity\Service;
use App\Entity\Schedule;
use App\Entity\Testimonial;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
        public function index(): Response
    {
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(CarsCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Espace Administrateur')
            ->setFaviconPath("/media/logo4.png")
            ->renderContentMaximized()
            ->disableDarkMode(true)
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Retour vers le site', 'fa-solid fa-house', 'app_home_index');
        yield MenuItem::linkToCrud('Véhicules', 'fa-solid fa-car', Car::class);
        yield MenuItem::linkToCrud('Demandes de contact', 'fa-solid fa-envelope', ContactMessage::class);
        yield MenuItem::linkToCrud('Avis', 'fa-regular fa-comment-dots', Testimonial::class);
        yield MenuItem::linkToCrud('Employés', 'fa-solid fa-users', User::class)->setPermission('ROLE_SUPER_ADMIN');
        yield MenuItem::linkToCrud('Services', 'fa-solid fa-wrench', Service::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Établissements', 'fa-solid fa-warehouse', Garage::class)->setPermission('ROLE_SUPER_ADMIN');
        yield MenuItem::linkToCrud('Horaires', 'fa-solid fa-circle-info', Schedule::class)
            ->setPermission('ROLE_SUPER_ADMIN')
            ->setAction(Action::EDIT)
            ->setEntityId(1)
        ;

    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->displayUserAvatar(false)
        ;
    }

    public function configureActions(): Actions
    {
        return parent::configureActions();
    }

}
