<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['attr' => ['placeholder' => "Nom du paquet"]])
            ->add('description', TextareaType::class, ['attr' => ['maxLength' => 500, 'minLength' => 5, 'placeholder' => 'Description (500 char max)']])
            ->add('libelle', TextType::class, ['attr' => ['placeholder' => "ex : PHRA"]])
            ->add('date_parution')
            ->add('img1', FileType::class, ["required"=>false,'mapped' => false, 'constraints' =>
            [new File(['maxSize' => '2048k', 'mimeTypes' => ['image/png', 'image/jpg', 'image/jpeg', 'image/jp2'], 'mimeTypesMessage' => 'Merci de selectionner un fichier au format png/jpg/jpeg/jp2 '])]])
            ->add('img2', FileType::class, ['required'=>false,'mapped' => false,  'constraints' =>
            [new File(['maxSize' => '2048k', 'mimeTypes' => ['image/png', 'image/jpg', 'image/jpeg', 'image/jp2'], 'mimeTypesMessage' => 'Merci de selectionner un fichier au format png/jpg/jpeg/jp2 '])]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
