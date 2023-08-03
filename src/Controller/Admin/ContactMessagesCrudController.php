<?php

namespace App\Controller\Admin;

use App\Entity\ContactMessage;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContactMessagesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ContactMessage::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('fullname')->setLabel('Nom');
        yield EmailField::new('email')->setLabel('Email');
        yield TelephoneField::new('phone')->setLabel('Téléphone');
        yield TextField::new('subject')->setLabel('Objet du message');
        yield AssociationField::new('car', 'Véhicule')
        ;
        yield TextField::new('message')->setLabel('Message');
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Message')
            ->setEntityLabelInPlural('Messages')
            ->setPageTitle('index', 'Liste des messages')
            ->setPaginatorPageSize(10)
            ->showEntityActionsInlined()
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW, Action::EDIT)
            ->set(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }
}
