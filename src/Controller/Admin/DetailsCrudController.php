<?php

namespace App\Controller\Admin;

use App\Entity\Details;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DomCrawler\Field\TextareaFormField;

class DetailsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Details::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Informations de l\'entreprise')
            ->setEntityLabelInPlural('Informations de l\'entreprise')
            ->setPageTitle('index', 'Informations de l\'entreprise')
            ->showEntityActionsInlined()
            ->setPaginatorRangeSize(0)
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
            TextEditorField::new('description')->setLabel('Texte de présentation')
                ->onlyOnForms()
            ,
            TextEditorField::new('servicesDescription')->setLabel('Texte de présentation des services')
                ->onlyOnForms()
            ,
        ];
    }

    function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
//            ->remove(Crud::PAGE_INDEX, Action::NEW)
//            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->disable(Action::NEW, Action::DELETE)
            ->remove(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)
            ;
    }

}
