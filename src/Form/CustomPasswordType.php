<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class CustomPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'constraints' => [new Regex([
                'pattern' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/",
                'message' => 'Le mot de passe doit contenir au minimum 12 caractères dont une minuscule, une majuscule, un chiffre, un caractère spéciale',
            ])],
            'first_options' => [
                'label' => 'Mot de passe',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Tapez votre nouveau mot de passe'
                ],
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ]
            ],
            'second_options' => [
                'label' => 'Confirmez le mot de passe',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Confirmez le mot de passe'
                ],
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ]
            ],
        ])


//            ->add('password', RepeatedType::class, [
//            'type' => PasswordType::class,
//            'constraints' => [new Regex([
//                'pattern' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/",
//                'groups' => ['registration'],
//                'message' => 'Le mot de passe doit contenir au minimum 12 caractères dont une minuscule, une majuscule, un chiffre, un caractère spéciale'
//            ])],
//            'options' => ['attr' => ['class' => 'password-field']],
//            'required' => true,
//            'first_options'  => ['label' => 'Nouveau mot de passe'],
//            'second_options' => ['label' => 'Retapez votre nouveau mot de passe'],
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
