<?php

namespace App\Form;

use App\Entity\Carroussel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CarrousselType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class, ['attr' => ['placeholder' => "Nom du carroussel (le nom du carroussel doit correspondre a son emplacement)"]] )
        ->add('image1', FileType::class, ["required"=>false,'mapped' => false, 'constraints' =>
        [new File(['maxSize' => '2048k', 'mimeTypes' => ['image/png', 'image/jpg', 'image/jpeg', 'image/jp2'], 'mimeTypesMessage' => 'Merci de selectionner un fichier au format png/jpg/jpeg/jp2 '])]])
        ->add('image2', FileType::class, ['required'=>false,'mapped' => false,  'constraints' =>
        [new File(['maxSize' => '2048k', 'mimeTypes' => ['image/png', 'image/jpg', 'image/jpeg', 'image/jp2'], 'mimeTypesMessage' => 'Merci de selectionner un fichier au format png/jpg/jpeg/jp2 '])]])
         ->add('image3', FileType::class, ['required'=>false,'mapped' => false,  'constraints' =>
        [new File(['maxSize' => '2048k', 'mimeTypes' => ['image/png', 'image/jpg', 'image/jpeg', 'image/jp2'], 'mimeTypesMessage' => 'Merci de selectionner un fichier au format png/jpg/jpeg/jp2 '])]])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Carroussel::class,
        ]);
    }
}
