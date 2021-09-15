<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Adresses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AdressesUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['attr'=> ['placeholder' => 'Nom']])
            ->add('pays', TextType::class, ['attr'=> ['placeholder' => 'Pays']])
            ->add('ville', TextType::class, ['attr'=> ['placeholder' => 'Ville']])
            ->add('rue', TextType::class, ['attr'=> ['placeholder' => 'rue']])
            ->add('codepostal', IntegerType::class, ['attr'=> ['placeholder' => 'code postal']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adresses::class,
        ]);
    }
}
