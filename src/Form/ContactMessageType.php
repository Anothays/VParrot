<?php

namespace App\Form;

use App\Entity\ContactMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prénom'
                ],
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom'
                ],
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ]
            ])
            ->add('subject', TextType::class, [
                'label' => 'Objet',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Objet'
                ],
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'e-mail',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'votre e-mail'
                ],
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ],
            ])
            ->add('phone', TelType::class, [
                'label' => 'Numéro de téléphone (facultatif)',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'téléphone',
                    'pattern' => "^[0-9]{10}$",
                    'title' => '0123456789',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre demande',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Écrivez ici votre message'
                ],
                'label_attr' => [
                    'class' => 'form-label  mt-4'
                ]
            ])
            ->add('termsAccepted', CheckboxType::class, [
                'label' => "Vous consentez à ce que vos données soient sauvegardées pour traitement de ce formulaire",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactMessage::class,
        ]);
    }
}
