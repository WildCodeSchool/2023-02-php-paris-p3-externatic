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
use Doctrine\ORM\EntityRepository;

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
            ->add('offerPicture', VichFileType::class, [
                'required'      => false,
                'allow_delete'  => true,
            ])
            ->add('minSalary', IntegerType::class)
            ->add('maxSalary', IntegerType::class)
            ->add('location', TextType::class)
            ->add('interviewProcess', TextareaType::class)
            ->add('skills', EntityType::class, [
                'label' => 'Required skills',
                'class' => Skill::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
