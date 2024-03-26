<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Notifier\Exception\LengthException;
use Symfony\Component\Validator\Constraints\Length;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label'=>"Adresse e-mail",
                'attr'=>[
                    'placeholder' => 'Indiquez votre adresse e-mail'
                ]
            ]) 
           
          
            ->add('plainPassword', RepeatedType::class,[ 
                 'type' => PasswordType::class,
                    'constraints' => [new Length(['min' => 3,'max' => 30])],
                 'first_options'  => 
                 ['label' => 'Mot de passe',
                 'attr'=>[
                    'placeholder' => 'Indiquez votre mot de passe'],
                    'hash_property_path' => 'password', ],
                 'second_options' => [
                 'label' => 'Confirmer votre mot de passe',
                 'attr'=>[
                     'placeholder' => 'Confirmez votre mot de passe'],
                    'hash_property_path' => 'password' ],
                 'mapped' => false,
            ])


            ->add('firstname',TextType::class,[
                'label'=>"Nom",
                'constraints' => [new Length(['min' => 2,'max' => 30])],
                'attr'=>[
                    'placeholder' => 'Indiquez votre nom'
                ]
            ])
            ->add('lastname', TextType::class,[
                'label'=>"Prenom",
                'constraints' => [new Length(['min' => 2,'max' => 30])],
                'attr'=>[
                    'placeholder' => 'Indiquez votre prenom'
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label'=>"Valider",
                'attr'=>[
                    'class'=> 'btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints' => [new UniqueEntity ([
                'entityClass'=> User::class,
                'fields'=>'email'])],
            'data_class' => User::class,
        ]);
    }
}
