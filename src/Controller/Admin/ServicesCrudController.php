<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;


class ServicesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name')->setLabel('Nom de la prestation');
        yield TextareaField::new('description')->setLabel('description de la prestation');

        yield TextField::new('imageFile', 'Image')
            ->setFormType(VichImageType::class)
            ->onlyOnForms()
        ;

        yield ImageField::new('imageName')
            ->setBasePath("media/photos/Service")
            ->onlyOnIndex()
        ;
        yield AssociationField::new('user', 'Ajouté par')
            ->setValue($this->getUser())
            ->hideOnForm()
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Prestation')
            ->setEntityLabelInPlural('Prestations')
            ->setPageTitle('index', 'Liste des prestations')
            ->setPaginatorPageSize(10)
            ->showEntityActionsInlined()
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
        ;
    }

}
