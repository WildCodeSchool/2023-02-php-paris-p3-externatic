<?php

namespace App\Form;

use App\Entity\Candidate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class UploadResumeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $fileConstraints = [
        //     new File([
        //         'maxSize' => '5M'
        //     ])
        // ];
        $builder
            ->add('resumeFile', DropzoneType::class, [

                // 'validation_groups' => [
                //     DropzoneType::class,
                //     'Default'
                // ],


                'attr' => [ 'placeholder' => 'Drag & drop or browse your file', 'accept' => 'resume/pdf'],
                // 'constraints' => [
                //     new Assert\File([
                //        'maxSize' => '2M',
                //        'mimeTypes' => ['resume/pdf'],
                //     ]),
                //  ],

                // 'mapped' => false,
                'required' => false,
                'label' => false,
                // 'constraints' =>  $fileConstraints,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class,
        ]);
    }
}
