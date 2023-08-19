<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\CustomPasswordType;
use App\Repository\UserRepository;
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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


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
            ->setFormOptions(
              ['validation_groups' => ['registration']],
              ['validation_groups' => ['update']],
            )
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
            ->add( Crud::PAGE_INDEX,Action::DETAIL)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('name', 'Prénom'),
            TextField::new('lastName', 'Nom'),
            AssociationField::new('garage', 'Établissement')->setRequired(false),
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
                ->setDisabled()
        ];

        $passwordFieldCreate = TextField::new('password', 'Mot de passe')
            ->onlyWhenCreating()
            ->setFormType(RepeatedType::class)
            ->setFormTypeOptions([
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmez le mot de passe'],
            ])
        ;
        $fields[] = $passwordFieldCreate;

        $roleField = ChoiceField::new('roles', 'Rôles attribués')
            ->setPermission('ROLE_SUPER_ADMIN')
            ->hideOnIndex()
            ->allowMultipleChoices()
            ->setChoices([
                'Administrateur' => 'ROLE_ADMIN',
                'Utilisateur' => 'ROLE_USER'
            ])
            ->renderExpanded()
        ;

        // L'utilisateur actuellement connecté ne peut pas changer son propre rôle
        if (strval($this->getUser()->getId()) === $this->requestStack->getCurrentRequest()->query->get("entityId")) {
            $roleField->hideOnForm();
        }

        $fields[] = $roleField;

        return $fields;
    }

    public function changePassword(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(CustomPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentUser = $this->getUser();
            $pw = $userPasswordHasher->hashPassword($currentUser, $form->getData()->getPassword());
            $userRepository->upgradePassword($currentUser, $pw);
            $this->addFlash('success','Votre mot de passe a bien été changé');

            return $this->redirectToRoute('admin');
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger','Erreur de validation du mot de passe');

        }

        return $this->render('admin/reset-password.html.twig', [
            'form' => $form
        ]);

    }

}
