<?php

namespace App\Controller\Admin;

use App\Entity\Cars;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CarsCrudController extends AbstractCrudController
{
    private ParameterBag $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
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
            ->setPageTitle('index', 'Dashboard des véhicules')
            ->setPaginatorPageSize(10)

            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('brand'),
            TextField::new('model'),
            IntegerField::new('mileage'),
            NumberField::new('price'),
            IntegerField::new('registration_year'),
            ImageField::new('image_name')
                ->setBasePath('/build/images/upload/300x300')
                ->setUploadDir($this->parameterBag->get('public_images_upload'))
                ->setFormTypeOptions([
                    'label' => 'Image du véhicule',
                    'allow_file_upload' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
                ])
                ->addJsFiles('/thumbnail.js')
            ,
            DateField::new('modifiedAt')
                ->hideWhenCreating()
                ->setFormTypeOptions([
                'label' => 'Dernière modification',
                'disabled' => 'disabled'
                ]),
            DateField::new('createdAt')
                ->hideWhenCreating()
                ->setFormTypeOptions([
                'label' => 'Crée le',
                'disabled' => 'disabled'
                ]),
//            TextEditorField::new('description'),
        ];
    }



}
