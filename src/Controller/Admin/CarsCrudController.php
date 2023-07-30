<?php

namespace App\Controller\Admin;

use App\Entity\Cars;
use App\Form\PhotosType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
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
        return Cars::class;
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
            yield TextField::new('brand')->setLabel('Constructeur');
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
                ->setEntryType(PhotosType::class)
                ->hideOnIndex();
            yield DateTimeField::new('modifiedAt')
                ->hideWhenCreating()
                ->setLabel('Modifié')
                ->setFormTypeOptions([
                'label' => 'Dernière modification',
                'disabled' => 'disabled'
                ]);
            yield DateTimeField::new('createdAt')
                ->hideWhenCreating()
                ->setLabel('Crée')
                ->setFormTypeOptions([
                'label' => 'Crée le',
                'disabled' => 'disabled'
                ]);
            yield ImageField::new('photos[0]')
                ->setLabel('Photos')
                ->setBasePath('/media/photos')
                ->setUploadDir('public/media/photos')
                ->setFormTypeOptions([
                    'label' => 'Image du véhicule',
                    'allow_file_upload' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
                ]);

//            TextEditorField::new('description'),

    }



}
