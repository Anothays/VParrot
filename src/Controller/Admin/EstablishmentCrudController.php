<?php

namespace App\Controller\Admin;

use App\Entity\Establishment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EstablishmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Establishment::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('siteName', 'Nom du site'),
            AssociationField::new('cars', 'Véhicules'),
            AssociationField::new('users', 'Employés'),
        ];
    }

}
