<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use App\Entity\Establishment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EstablishmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Establishment::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInSingular('Établissement')
            ->setEntityLabelInPlural('Établissements')
            ->showEntityActionsInlined()
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('siteName', 'Nom du site'),
            AssociationField::new('cars', 'Véhicules')
                ->setFormTypeOptionIfNotSet('by_reference', false)
            ,
            AssociationField::new('users', 'Employés')
                ->setFormTypeOptionIfNotSet('by_reference', false)
            ,
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);
        if (!$this->isGranted('ROLE_SUPER_ADMIN')) {
            $actions
                ->disable(Action::DELETE)
                ->disable(Action::EDIT)
                ->disable(Action::NEW)
                ;
        }
        return $actions;
    }
}
