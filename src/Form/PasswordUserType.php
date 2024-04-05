<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;

class PasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
        ->add('actualPassword', PasswordType::class, [
            'label' => "Votre mot de passe actuel",
            'attr' => [
                'placeholder' => 'Votre mot de passe actuel'
               
            ],
            'mapped' => false
        ])

        ->add('plainPassword', RepeatedType::class,[ 
            'type' => PasswordType::class,
               'constraints' => [new Length(['min' => 3,'max' => 30])],
            'first_options'  => 
            ['label' => 'Choissisez votre nouveau mot de passe',
            'attr'=>[
               'placeholder' => 'Indiquez votre nouveau mot de passe'],
               'hash_property_path' => 'password' 
            ],

            'second_options' => [
            'label' => 'Confirmer votre nouveau  mot de passe',
            'attr'=>[
                'placeholder' => 'Confirmez votre nouveau mot de passe'
                ]
            ],
            'mapped' => false,
            ])

            ->add('submit', SubmitType::class,[
                'label'=>"Mettre a jour votre mot de passe",
                'attr'=>[
                    'class'=> 'btn btn-success'
            ]
       ])

       ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event){

                $form = $event ->getForm();
                $user = $form->getConfig()->getOptions()['data'];
                $passwordHasher = $form->getConfig()->getOptions()['passwordHasher'];

                $isValid = $passwordHasher->isPasswordValid(
                    $user,
                    $form->get('actualPassword')->getData()
                );
                

                if(!$isValid) {
                    $form->get('actualPassword')->addError(new FormError ("Votre mot de passe actuel n'est pas conforme"));
                }
       })

       ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'passwordHasher'=> null
        ]);
    }

    
}
