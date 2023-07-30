<?php

namespace App\Controller\Admin;

use App\Entity\Testimonials;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TestimonialsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Testimonials::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Témoignage')
            ->setEntityLabelInPlural('Témoignages')
            ->setPageTitle('index', 'Liste des témoignages')
            ->setPaginatorPageSize(20)
            ->showEntityActionsInlined()
            ;
    }

    public function configureFields(string $pageName): iterable
    {

        yield TextField::new('author')->setLabel('Autheur');
        yield ChoiceField::new('note')->setLabel('note')
            ->setChoices([
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
            ])
        ;
        yield TextField::new('comment')->setLabel('Commentaire');
        yield DateTimeField::new('created_at')
            ->hideWhenCreating()
            ->setFormTypeOptions([
                'label' => 'Crée le',
                'disabled' => 'disabled'
                ])
            ->setLabel('Crée');
        yield DateTimeField::new('modified_at')
            ->hideWhenCreating()
            ->setFormTypeOptions([
                'label' => 'Crée le',
                'disabled' => 'disabled'
                ])
            ->setLabel('Modifié');
        yield BooleanField::new('validated')->setLabel('approuvé');

    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ;
    }

}
