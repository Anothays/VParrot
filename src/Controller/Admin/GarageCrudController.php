<?php

namespace App\Controller\Admin;

use App\Entity\Garage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GarageCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Garage::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', "Nom de l'établissement"),
            TextField::new('email', "Email"),
            TextField::new('phoneNumber', "Téléphone"),
            TextField::new('address', "Adresse postale"),
            AssociationField::new('users', "Employés")->setFormTypeOption('by_reference', false),
            AssociationField::new('services', 'Prestations proposées')->setFormTypeOption('by_reference', false),
            AssociationField::new('cars', 'Voitures à vendre')->setFormTypeOption('by_reference', false),
        ];
    }
}
