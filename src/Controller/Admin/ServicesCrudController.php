<?php

namespace App\Controller\Admin;

use App\Entity\Services;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;


class ServicesCrudController extends AbstractCrudController
{

    private ParameterBag $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public static function getEntityFqcn(): string
    {
        return Services::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name')->setLabel('Nom de la prestation');
        yield TextareaField::new('description')->setLabel('description de la prestation');
//        yield VichImageField::new('imageName');
        yield TextField::new('imageFile')
            ->setFormType(VichImageType::class)
            ->onlyOnForms()
        ;
        yield ImageField::new('imageName')
            ->setBasePath("media/photos/Services")
            ->onlyOnIndex()
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

}
