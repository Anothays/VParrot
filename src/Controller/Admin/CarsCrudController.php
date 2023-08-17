<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use App\Form\PhotoType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class CarsCrudController extends AbstractCrudController
{

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
            yield IntegerField::new('registration_year')->setLabel('Année');
            yield AssociationField::new('garage', 'Lieu de stockage');
            yield CollectionField::new('photos')
                ->setEntryType(PhotoType::class)
                ->setFormTypeOption('error_bubbling', false)
                ->hideOnIndex()
            ;
            yield DateTimeField::new('createdAt', 'Crée le')
                ->hideOnIndex()
                ->hideWhenCreating()
                ->setFormTypeOptions([
                'label' => 'Crée le',
                'disabled' => 'disabled'
                ])
            ;
            yield DateTimeField::new('modifiedAt', 'Modifié le')
                ->hideOnIndex()
                ->hideWhenCreating()
                ->setFormTypeOptions([
                    'label' => 'Dernière modification',
                    'disabled' => 'disabled'
                ])
            ;
            yield TextField::new('createdBy', "Auteur de l'annonce")
                ->onlyWhenUpdating()
                ->setDisabled()
            ;
            yield ImageField::new('filenames[0]')
                ->setLabel('Photo')
                ->setBasePath('/media/photos')
                ->setUploadDir('public/media/photos')
                ->setFormTypeOptions([
                    'label' => 'Image du véhicule',
                    'allow_file_upload' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
                ])
                ->onlyOnIndex()
            ;
            yield BooleanField::new('published', 'Annonce visible');
    }
}
