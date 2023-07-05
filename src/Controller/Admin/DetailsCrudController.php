<?php

namespace App\Controller\Admin;

use App\Entity\Details;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ScheduleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Details::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Horaire')
            ->setEntityLabelInPlural('Horaires')
            ->setPageTitle('index', 'Dashboard des horaires')
            ->setPaginatorPageSize(10)
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex()->hideOnDetail(),
            TextField::new('day'),
            TextField::new('openMorningTime'),
            TextField::new('openAfternoonTime'),
        ];
    }

}
