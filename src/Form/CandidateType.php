<?php

namespace App\Form;

use App\Entity\Candidate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('picture')
            ->add('firstname', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Firstname',
                ],
            ])
            ->add('lastname', TextType::class, [
            'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Lastname',
                ],
            ])
            ->add('location', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Location',
            ],
            ])
            ->add('phone', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Phone number',
            ],
            'required' => false,
            ])
            ->add('jobTitle', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Job Title',
                ],
            ])
            ->add('experience')
            ->add('introduction', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Introduction about yourself',
                ],
            ])
            // ->add('skills')
            ->add('resume')
            ->add('visible', CheckboxType::class, [
                'label' => "I want my profile to be visible by recruiter",
                'attr' => ['class' => 'form-check-input',],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class,
        ]);
    }
}
