<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['attr' => ['placeholder' => "Nom de l'article"]])
            ->add('prix', NumberType::class,  ['scale'=>2 ,'attr' => ['placeholder' => "Le prix en EUR"]] )
            ->add('stock', IntegerType::class, ['attr' => ['placeholder' => "Quantité"]])
            ->add('img',FileType::class, ["required"=>false,'mapped' => false, 'help' => 'png,jpeg - 2 Mo max', 'constraints' =>
            [new File(['maxSize'=>'2048k', 'mimeTypes'=>['image/png','image/jpg','image/jpeg','image/jp2'], 'mimeTypesMessage'=>'Merci de selectionner un fichier au format png/jpg/jpeg/jp2 '])]]) 
            ->add('categorie', EntityType::class,['label'=>"categorie", 'class'=>Categorie::class, 'choice_label' => "nom"])
            ->add('libelle', TextType::class, ['attr'=> ['placeholder' => 'Libelle']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
