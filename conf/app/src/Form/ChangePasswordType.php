<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ChangePasswordType extends AbstractType
{ 
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    $builder
    ->add('plainPassword', PasswordType::class, [
        // instead of being set onto the object directly,
        // this is read and encoded in the controller
        'mapped' => false,
        'attr' => ['autocomplete' => 'new-password'],
        'constraints' => [
            new NotBlank([
                'message' => 'Please enter a password',
            ]),
            new Length([
                'min' => 8,
                'minMessage' => 'Your password should be at least {{ limit }} characters',
                // max length allowed by Symfony for security reasons
                'max' => 4096,
            ]),
            new Regex([
                'pattern' => '/[A-Z]/',
                'match' => true,
                'message' => 'Your password dont contain capital letters',
            ]),
            new Regex([
                'pattern' => '/[a-z]/',
                'message' => 'Your password dont contain a lowercase letter',
            ]),

        ],
        //    preg_match('[A-Z]';$string)  "message" => 'Pas de majuscule'
    ])
    ->add('plainPassword', RepeatedType::class, [ 
        // RepeatedType::class verifie le mot de passe
        'options'=>['attr'=>['class'=>'password-field']],
        'type'=>PasswordType::class,
        'mapped' => false,
        'constraints' => [
            new NotBlank([
                'message' => 'Please enter your password',
            ]),
            new Length([
                'min' => 8,
                'minMessage' => 'Your password should be at least {{ limit }} characters',
                // max length allowed by Symfony for security reasons
                'max' => 4096,
            ]),
            new Regex([
                'pattern' => '/[A-Z]/',
                'match' => true,
                'message' => 'Your password dont contain capital letters',
            ]),
            new Regex([
                'pattern' => '/[a-z]/',
                'message' => 'Your password dont contain a lowercase letter',
            ]),
            new Regex([
                'pattern' => '/[\d]/',
                'message' => 'You forgot to put a number',
            ]),
            new Regex([
                'pattern' => '/[\!\?\#]/',
                'message' => 'No special character',
            ]),
        ],
    ])
    ;
}

public function configureOptions(OptionsResolver $resolver): void
{
    $resolver->setDefaults([
        'data_class' => User::class,
    ]);
}
}
