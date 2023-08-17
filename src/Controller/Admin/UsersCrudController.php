<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\RequestStack;


class UsersCrudController extends AbstractCrudController
{

    public function __construct(private RequestStack $requestStack){}

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Employé')
            ->setEntityLabelInPlural('Employés')
            ->setPageTitle('index','Liste des employés')
            ->showEntityActionsInlined()
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermissions([
                Action::DELETE => 'ROLE_SUPER_ADMIN',
                Action::EDIT => 'ROLE_SUPER_ADMIN',
                Action::NEW => 'ROLE_SUPER_ADMIN',
            ])
        ;
    }


    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('name')->setLabel('Prénom'),
            TextField::new('lastName')->setLabel('Nom'),
            AssociationField::new('garage', 'Établissement'),
            EmailField::new('email')
                ->onlyWhenCreating()
                ->setFormType(RepeatedType::class)
                ->setFormTypeOptions([
                    'type' => EmailType::class,
                    'first_options' => ['label' => 'Email'],
                    'second_options' => ['label' => 'Confirmez l\'adresse email'],
                ]),
            EmailField::new('email', 'Email')
                ->hideWhenCreating()
                ->setDisabled(),
        ];

        $passwordField = TextField::new('password', 'Mot de passe')
            ->onlyOnForms()
            ->setFormType(RepeatedType::class)
            ->setFormTypeOptions([
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmez le mot de passe'],
            ])
        ;

        if ($this->getUser() !== $this->getContext()->getEntity()->getInstance()) {
            $passwordField->hideWhenUpdating();
        }

        $fields[] = $passwordField;
        $roleField = ChoiceField::new('roles', 'Rôles attribués')
            ->setPermission('ROLE_SUPER_ADMIN')
            ->onlyOnForms()
            ->allowMultipleChoices()
            ->setChoices([
                'Administrateur' => 'ROLE_ADMIN',
                'Utilisateur' => 'ROLE_USER'
            ])
        ;

        // L'utilisateur actuellement connecté ne peut pas changer son propre rôle
        if (strval($this->getUser()->getId()) === $this->requestStack->getCurrentRequest()->query->get("entityId")) {
            $roleField->hideOnForm();
        }

        $fields[] = $roleField;

        return $fields;
    }

}
