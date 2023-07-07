<?php

namespace App\Form;

use App\Entity\Candidate;
use App\Entity\CandidateMetadata;
use App\Entity\Offer;
use App\Entity\Skill;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
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
            ->add('phone', TelType::class, [
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
            ->add('experience', ChoiceType::class, [
                'placeholder' => 'Years of experience',
                'attr' => ['class' => 'form-select'],
                'label' => false,
                'choices' => Offer::EXPERIENCE,
            ])
            ->add('introduction', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Introduction about yourself',
                ],
            ])
            ->add('skills', EntityType::class, [
                'class' => Skill::class,
                'choice_label' => 'name',
                'label' => 'Skills',
                'expanded' => true,
                'multiple' => true,
                'by_reference' => false,
            ])
            ->add('resume', TextType::class, [
                'required' => false,
            ])
            ->add('metadata', CollectionType::class, [
                'entry_type' => MetadataType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'by_reference' => false,
            ])
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
