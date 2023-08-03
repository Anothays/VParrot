<?php

namespace App\Controller\Admin;

use App\Controller\Admin\CustomFields\VichImageField;
use App\Entity\CarConstructors;
use App\Entity\Car;
use App\Form\PhotoType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;

class CarsCrudController extends AbstractCrudController
{

    public function __construct(public ParameterBagInterface $parameterBag)
    {
    }

    public static function getEntityFqcn(): string
    {
        return Car::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Véhicule')
            ->setEntityLabelInPlural('Véhicules')
            ->setPageTitle('index', 'Liste des véhicules')
            ->setPaginatorPageSize(10)
            ->showEntityActionsInlined()
            ;
    }

    public function configureFields(string $pageName): iterable
    {

//            yield IdField::new('id')->hideOnForm();
            yield TextField::new('constructor')->setLabel('Constructeur');
            yield TextField::new('model')->setLabel('Modèle');
            yield TextField::new('licensePlate')->setLabel('Immatriculation');
            yield ChoiceField::new('engine')->setLabel('Moteur')
                ->setChoices([
                    'Essence' => 'Essence',
                    'Diesel' => 'Diesel',
                    'Électrique' => 'Électrique',
                    'Hybrid' => 'Hybrid'
                ])
            ;
            yield IntegerField::new('mileage')->setLabel('Kilométrage');
            yield NumberField::new('price')->setLabel('Prix');
//            yield IntegerField::new('reference')
//                ->setLabel('Référence de la voiture');
            yield IntegerField::new('registration_year')->setLabel('Année');
            yield CollectionField::new('photos')
                ->setEntryType(PhotoType::class)
                ->hideOnIndex();
            yield DateTimeField::new('createdAt', 'Crée le')
                ->hideWhenCreating()
                ->setFormTypeOptions([
                'label' => 'Crée le',
                'disabled' => 'disabled'
                ]);
            yield DateTimeField::new('modifiedAt', 'Modifié le')
                ->hideWhenCreating()
                ->setFormTypeOptions([
                    'label' => 'Dernière modification',
                    'disabled' => 'disabled'
                ]);
            yield AssociationField::new('establishment', 'Stocké dans l\'établissement');
            yield AssociationField::new('user', 'Ajouté par')
                ->setValue($this->getUser())
//                ->hideOnForm()
            ;
            yield VichImageField::new('photos')
                ->setLabel('Photo')
                ->setBasePath('/media/photos')
                ->setUploadDir('public/media/photos')
                ->setFormTypeOptions([
                    'label' => 'Image du véhicule',
                    'allow_file_upload' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
                ])
                ->onlyOnIndex()
            ;
//            yield ImageField::new('filenames[0]')
//                ->setLabel('Photo')
//                ->setBasePath('/media/photos')
//                ->setUploadDir('public/media/photos')
//                ->setFormTypeOptions([
//                    'label' => 'Image du véhicule',
//                    'allow_file_upload' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
//                ])
//                ->onlyOnIndex()
//            ;
    }



}
