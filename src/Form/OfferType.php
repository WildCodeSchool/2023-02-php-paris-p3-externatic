<?php

namespace App\Form;

use App\Entity\Offer;
use App\Entity\Skill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Validator\Constraints\Count;
use Doctrine\ORM\EntityRepository;
use Symfony\UX\Dropzone\Form\DropzoneType;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control border-primary',
                    'placeholder' => 'Title',
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ],
            ])
            ->add('startAt', DateType::class, [
                'label' => 'Starting date',
                'widget' => 'single_text',
                'by_reference' => true,
            ])
            ->add('contract', ChoiceType::class, [
                'placeholder' => 'Contract',
                'label' => false,
                'choices' => Offer::JOB_TYPE,
                'attr' => [
                    'class' => 'form-select border-primary',
                    'aria-label' => 'Default select example',
                ]
            ])
            ->add('workFromHome', ChoiceType::class, [
                'placeholder' => 'work from home',
                'label' => false,
                'choices' => Offer::WORK_FROM_HOME,
                'attr' => [
                    'class' => 'form-select border-primary',
                    'aria-label' => 'Default select example',
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control border-primary',
                    'placeholder' => 'Description',
                ],
            ])
            ->add('experience', ChoiceType::class, [
                'placeholder' => 'Years of experience',
                'choices' => Offer::EXPERIENCE,
                'label' => false,
                'attr' => [
                    'class' => 'form-select border-primary',
                    'aria-label' => 'Default select example',
                    'placeholder' => 'Level of experience (in years)',
                ]
            ])
            ->add('offerPicture', DropzoneType::class, [
                'required'      => false,
                'label'         => false,
                'attr' => [
                    'placeholder' => 'Browse your picture offer here',
                ],
            ])
            ->add('minSalary', IntegerType::class, [
                'label' => false,
                'constraints' => [
                    new Assert\GreaterThan(1000),
                    new Assert\NotBlank()
                ],
                'attr' => [
                    'class' => 'form-control border-primary',
                    'placeholder' => 'Min salary',
                ],
            ])
            ->add('maxSalary', IntegerType::class, [
                'label' => false,
                'constraints' => [
                    new Assert\GreaterThan(1000)
                ],
                'attr' => [
                    'class' => 'form-control border-primary',
                    'placeholder' => 'Max salary',
                ],
            ])
            ->add('location', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control border-primary',
                    'placeholder' => 'Location',
                ],
            ])
            ->add('interviewProcess', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control border-primary',
                    'placeholder' => '1. Call with HR 2.Technical Test 3.Last interview',
                ],
                    'empty_data' => '1. Call with HR 2.Technical Test 3.Last interview',
            ])
            ->add('skills', EntityType::class, [
                'label' => 'Required skills',
                'class' => Skill::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
                'constraints' => array(
                    new Count(['min' => 1, 'minMessage' => 'Please select at least one skill'])
                )
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
