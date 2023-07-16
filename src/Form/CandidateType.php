<?php

namespace App\Form;

use App\Entity\Candidate;
use App\Entity\Offer;
use App\Entity\Skill;
use Symfony\Component\Form\AbstractType;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count as Count;

class CandidateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pictureFile', DropzoneType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Browse your picture profile here',
                ],
            ])
            ->add('firstname', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control border-primary',
                    'placeholder' => 'Firstname',
                ],
            ])
            ->add('lastname', TextType::class, [
            'label' => false,
                'attr' => [
                    'class' => 'form-control border-primary',
                    'placeholder' => 'Lastname',
                ],
            ])
            ->add('location', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control border-primary',
                'placeholder' => 'Location',
                ],
            ])
            ->add('phone', TelType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control border-primary',
                'placeholder' => 'Phone number',
                ],
            'required' => false,
            ])
            ->add('jobTitle', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control border-primary',
                    'placeholder' => 'Job Title',
                ],
            ])
            ->add('experience', ChoiceType::class, [
                'placeholder' => 'Years of experience',
                'attr' => ['class' => 'form-select border-primary'],
                'label' => false,
                'choices' => Offer::EXPERIENCE,
            ])
            ->add('introduction', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control border-primary',
                    'placeholder' => 'Introduction about yourself',
                ],
            ])
            ->add('skills', EntityType::class, [
                'choice_label' => 'name',
                'class' => Skill::class,
                'attr' => [
                    'class' => 'form-check-input',
                    'label_class' => 'form-check-label',
                ],
                'expanded' => true,
                'multiple' => true,
                'by_reference' => false,
                'constraints' => [
                    new Count([
                        'min' => 1, 'minMessage' => 'Please select at least one hard skill and one soft skill'
                    ]),
                ]
            ])
            ->add('resumeFile', DropzoneType::class, [
                'required' => false,
                'label' => true,
                'attr' => [
                    'placeholder' => 'Drag and drop a file or click to browse',
                ],
            ])
            ->add('metadata', CollectionType::class, [
                'entry_type' => MetadataType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'label' => false,
                'by_reference' => false,
            ])
            ->add('visible', CheckboxType::class, [
                'label' => "I want my profile to be visible by recruiter",
                'attr' => ['class' => 'form-check-input'],
                'label_attr' => ['class' => 'fs-5'],
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class,
        ]);
    }
}
