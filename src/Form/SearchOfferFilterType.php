<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Offer;
use App\Entity\Skill;
use PhpParser\Parser\Multiple;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchOfferFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('searchTitle', SearchType::class, [
                'required' => false,
                'label' => 'Find a job',
            ])
            ->add('searchLocation', SearchType::class, [
                'required' => false,
                'label' => 'Location',
            ])
            ->add('contract', ChoiceType::class, [
                'choices' => Offer::JOB_TYPE,
                'required' => false,
                'label' => 'Type of job',
                'expanded' => true,
                'multiple' => true,
                'attr' => [
                    'class' => 'dropdown-item form-check'
                ],
            ])
            ->add('salary', IntegerType::class, [
                'label' => 'Salary minimum required',
                'required' => false,
                'attr' => [
                    'placeholder' => '30000',
                ]
            ])
            ->add('companySector', ChoiceType::class, [
                'choices' => Company::COMPANY_SECTOR,
                'required' => false,
                'label' => 'Company sector',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('skills', EntityType::class, [
                'choice_label' => 'name',
                'class' => Skill::class,
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('experience', ChoiceType::class, [
                'choices' => Offer::EXPERIENCE,
                'required' => false,
                'label' => 'Years of experience',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('workFromHome', ChoiceType::class, [
                'choices' => Offer::WORK_FROM_HOME,
                'required' => false,
                'label' => 'Work from home',
                'expanded' => true,
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
