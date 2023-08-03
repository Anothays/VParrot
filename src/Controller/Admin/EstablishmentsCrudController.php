<?php

namespace App\Controller\Admin;

use App\Entity\Establishment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EstablishmentsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Establishment::class;
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


//    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
//    {
//        return parent::getRedirectResponseAfterSave($context, $action);
//    }

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