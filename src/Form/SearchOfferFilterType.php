<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Offer;
use PhpParser\Parser\Multiple;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ])
            ->add('salary', RangeType::class, [
                'attr' => [
                    'min' => 20000,
                    'max' => 80000,
                ],
                'label' => 'Salary'
            ])
            ->add('companySector', ChoiceType::class, [
                'choices' => Company::COMPANY_SECTOR,
                'required' => false,
                'label' => 'Company sector',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('experience', ChoiceType::class, [
                'choices' => Offer::EXPERIENCE,
                'required' => false,
                'label' => 'Experience',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('workFromHome', ChoiceType::class, [
                'choices' => Offer::WORK_FROM_HOME,
                'required' => false,
                'label' => 'Work from home',
                'expanded' => true,
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
