<?php

namespace App\Controller\Admin;

use App\Entity\Details;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DetailsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Details::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Information')
            ->setEntityLabelInPlural('Informations')
            ->setPageTitle('index', 'Informations de l\'entreprise')

            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex()->hideOnDetail(),
            TelephoneField::new('telephone')->setLabel('Numéro de téléphone'),
            EmailField::new('Email')->setLabel('Adresse e-mail'),
            TextField::new('address')->setLabel('Adresse postale'),
            ArrayField::new('openedDays')
                ->setLabel('Horaires d\'ouverture')
                ->onlyOnForms()
            ,
        ];
    }

}
