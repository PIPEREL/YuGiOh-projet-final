<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom',TextType::class, ['attr' =>['maxLength' => 100, 'placeholder' => 'Nom']])
            ->add('Prenom',TextType::class, ['attr' =>['maxLength' => 100, "placeholder" => "Prenom"]])
            ->add('email', EmailType::class, ['attr' =>['maxLength' => 100, "placeholder" => "adresse email"]])
            ->add(
                'objet', ChoiceType::class, [
                    'choices' => [' - objet - '=>'', 'question sur un produit' => 'question', 'problème de livraison' => 'livraison', 'réclamation' => "claim" ],
                    'expanded' => false,
                    'multiple' => false,
                ])
            ->add('message', TextareaType::class, ['attr'=> ['maxLength' => 100,'minLength'  => 50], 'help' =>'100 char max'])
            ->add('envoyer', SubmitType::class) // c'est optionel
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
