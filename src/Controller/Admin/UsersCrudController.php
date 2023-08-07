<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\DBAL\Types\JsonType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UsersCrudController extends AbstractCrudController
{
    private $userPasswordHasher;
    private $request;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher, RequestStack $requestStack)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->request = $requestStack->getCurrentRequest();
    }

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
//            ->add(Crud::PAGE_INDEX, Action::DETAIL)
//            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->setPermissions([
                Action::DELETE => 'ROLE_ADMIN',
                Action::EDIT => 'ROLE_ADMIN',
                Action::NEW => 'ROLE_ADMIN',
            ])
            ;
    }


    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('name')->setLabel('Prénom'),
            TextField::new('lastName')->setLabel('Nom'),
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
            ]);
        if ($this->getUser() !== $this->getContext()->getEntity()->getInstance()) {
            $passwordField->hideWhenUpdating();
        }
        $roleField = ChoiceField::new('roles', 'Rôles attribués')
            ->setPermission('ROLE_SUPER_ADMIN')
            ->allowMultipleChoices()
            ->setChoices([
                'Administrateur' => 'ROLE_ADMIN',
                'Utilisateur' => 'ROLE_USER'
            ]);


        if (strval($this->getUser()->getId()) === $this->request->query->get("entityId")) {
            $roleField->hideOnForm();
        }

        $fields[] = $roleField;
        $fields[] = $passwordField;
        return $fields;
    }

//    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
//    {
//        $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);
//        return $this->addPasswordEventListener($formBuilder);
//    }
//
//    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
//    {
//        $formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);
//        return $this->addPasswordEventListener($formBuilder);
//    }
//
//    private function addPasswordEventListener(FormBuilderInterface $formBuilder): FormBuilderInterface
//    {
//        return $formBuilder->addEventListener(FormEvents::POST_SUBMIT, $this->formatSubmitFormData());
//    }
//
//    private function formatSubmitFormData() {
//        return function($event) {
//            $form = $event->getForm();
//
//            if (!$form->isValid()) {
//                return;
//            }
//
//            // Hash password
//            $password = $form->get('password')->getData() ;
//            if ($password) {
//                $hash = $this->userPasswordHasher->hashPassword($this->getUser(), $password);
//                $form->getData()->setPassword($hash);
//            }
//
//            // format Roles
////            $roles = $form->get('roles')->getData();
//////            dd($roles);
////            if ($roles) {
////                $form->getData()->setRoles($roles);
////            }
//        };
//    }

}
