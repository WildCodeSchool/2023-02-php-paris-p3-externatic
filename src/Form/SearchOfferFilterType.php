<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Offer;
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
            ->add('searchTitle', SearchType::class)
            ->add('searchLocation', SearchType::class)
            ->add('contract', ChoiceType::class, [
                'choices' => Offer::JOB_TYPE
            ])
            ->add('salary', RangeType::class)
            ->add('companySector', ChoiceType::class, [
                'choices' => Company::COMPANY_SECTOR
            ])
            ->add('experience', ChoiceType::class, [
                'choices' => Offer::EXPERIENCE
            ])
            ->add('workFromHome', ChoiceType::class, [
                'choices' => Offer::WORK_FROM_HOME
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
