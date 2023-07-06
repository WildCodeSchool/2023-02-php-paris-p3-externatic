<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('roles', ChoiceType::class, [
            'label' => false,
            'choices' => [
                'Candidate' => User::ROLE_CANDIDATE,
                'Company' => User::ROLE_COMPANY,
            ],
            'attr' => [
                'class' => 'switch-custom',
                'class-label' => 'form-check-label',
            ],
            'label_attr' => ['class' => 'switch-custom'],
            'expanded' => true,
            'multiple' => true,
        ])
            ->add('login', EmailType::class, [
                'label' => false,
                'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Email',
                ],
            ])
            ->add('RGPDconsent', CheckboxType::class, [
                'mapped' => false,
                'label' => 'I agree to the terms and conditions as set out by the user agreement',
                'attr' => [
                    'class' => 'form-check-input',
                    'class-label' => 'form-check-label',
                ],
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => false,
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password',
                'class' => 'form-control',
                'placeholder' => 'Define a password',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
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
