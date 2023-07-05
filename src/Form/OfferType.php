<?php

namespace App\Form;

use App\Entity\Offer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('startAt', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('contract', ChoiceType::class, [
                'choices' => Offer::JOB_TYPE,
                'required' => true,
                'label' => 'Contract',
            ])
            ->add('workFromHome', ChoiceType::class, [
                'choices' => Offer::WORK_FROM_HOME,
                'required' => true,
                'label' => 'Telework',
            ])
            ->add('description', TextareaType::class)
            ->add('experience', ChoiceType::class, [
                'choices' => Offer::EXPERIENCE,
                'required' => true,
                'label' => 'Level of experience (in years)',
            ])
            ->add('minSalary', IntegerType::class, [
                'constraints' => [
                    new Assert\LessThan([
                        'maxSalary'
                    ]),
                ]
            ])
            ->add('maxSalary', IntegerType::class, [
                'constraints' => [
                    new Assert\GreaterThan([
                        'minSalary'
                    ]),
                ]
            ])
            ->add('location', TextType::class)
            ->add('interviewProcess', TextareaType::class)
            ->add('picture', TextType::class)
            // ->add('skills', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
