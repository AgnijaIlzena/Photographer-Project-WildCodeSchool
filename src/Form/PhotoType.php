<?php

namespace App\Form;

use App\Entity\Photo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\UniqueValidator;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['image_is_required']) {
            $imageConstraint = new NotBlank([
                'message' => 'NOT BLANK !!',
            ]);
        } else {
            $imageConstraint = null;
        }


        $builder
            ->add('number')
            ->add('galery', null, ['choice_label' => 'title'])
            ->add('image', FileType::class, [
                 'label' => false,
                 'mapped' => false,
                 'required' => false,
                 'constraints' => $imageConstraint,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
            'image_is_required' => true,
        ]);
    }
}
