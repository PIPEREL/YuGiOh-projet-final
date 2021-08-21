<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('plainPassword', PasswordType::class, [
            // instead of being set onto the object directly,
            // this is read and encoded in the controller
            'required' => false,
            'mapped' => false,
            'attr' => ['autocomplete' => 'new-password', "placeholder"=> "Nouveau Mot de passe"],
            'constraints' => [
                // new NotBlank([
                //     'message' => 'un mot de passe svp',
                // ]),
                // new Length([
                //     'min' => 6,
                //     'minMessage' => 'Your password should be at least {{ limit }} characters',
                //     // max length allowed by Symfony for security reasons
                //     'max' => 4096,
                // ]),
                new PasswordStrength([
                    'minLength' => 8,
                    'tooShortMessage' => 'Le mot de passe doit contenir au moins {{length}} caractères',
                    'minStrength' => 4,
                    'message' => 'Le mot de passe doit au moins contenir une minuscule , une majuscule, un chiffre et un caractère spécial'
                ])
            ],
        ])
        ->add('confirmPassword', PasswordType::class, [
            // instead of being set onto the object directly,
            // this is read and encoded in the controller
            'mapped' => false,
            'attr' => ['autocomplete' => 'new-password', 'placeholder'=>" Confirmez le mot de passe"],
            'constraints' => [
                new NotBlank([
                    'message' => 'un mot de passe svp',
                ])
                ]
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
