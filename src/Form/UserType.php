<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class, ['label' => "nom", 'attr'=>["placeholder"=> "nom"]])
        ->add('prenom', TextType::class, ['label' => "prenom", 'attr'=>["placeholder"=> "prenom"]])
        ->add('email', EmailType::class, ['label' => "email", 'attr'=>["placeholder"=> "email"]])
            ->add(
                'roles', ChoiceType::class, [
                    'choices' => ['SUPER ADMIN' => 'ROLE_SUPERADMIN','ADMIN' => 'ROLE_ADMIN', 'USER' => 'ROLE_USER' ],
                    'expanded' => true,
                    'multiple' => true,
                ]
            )
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'required' => false,
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', "placeholder"=> "Mot de passe"],
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
