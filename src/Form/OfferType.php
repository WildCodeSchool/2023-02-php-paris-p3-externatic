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
                'label' => 'Job offer title',
                'attr' => [
                    'class' => 'form-control mb-4',
                    'placeholder' => 'Job offer title',
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ],
            ])
            ->add('startAt', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'mb-2',],
            ])
            ->add('contract', ChoiceType::class, [
                'label' => 'Contract',
                'choices' => Offer::JOB_TYPE,
                'required' => true,
                'attr' => ['class' => 'mb-2',],
            ])
            ->add('workFromHome', ChoiceType::class, [
                'label' => 'Telework',
                'choices' => Offer::WORK_FROM_HOME,
                'required' => true,
                'attr' => ['class' => 'mb-2',],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Job offer description',
                ],
            ])
            ->add('experience', ChoiceType::class, [
                'choices' => Offer::EXPERIENCE,
                'required' => true,
                'label' => 'Level of experience (in years)',
                'attr' => ['class' => 'mb-2',],
            ])
            ->add('offerPicture', VichFileType::class, [
                'required'      => false,
                'allow_delete'  => true,
                'attr' => ['class' => 'mb-2',],
            ])
            ->add('minSalary', IntegerType::class, [
                'attr' => ['class' => 'mb-2',],
                'constraints' => [
                    new Assert\GreaterThan(1000),
                    new Assert\NotBlank()
                ],
            ])
            ->add('maxSalary', IntegerType::class, [
                'attr' => ['class' => 'mb-2',],
                'constraints' => [
                    new Assert\GreaterThan(1000)
                ],
            ])
            ->add('location', TextType::class, [
                'label' => 'Location',
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Job Location',
                ],
            ])
            ->add('interviewProcess', TextareaType::class, [
                'label' => 'Recrutement Process',
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Recrutement Process',
                ],
            ])
            ->add('skills', EntityType::class, [
                'label' => 'Required skills',
                'class' => Skill::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
                'attr' => ['class' => 'mb-4',],
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
