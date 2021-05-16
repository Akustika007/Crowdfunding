<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Crowdfunding;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampaignFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'camp.name_label',
                'attr' => [
                    'placeholder' => 'camp.name_holder',
                ],
            ])

            ->add('description', TextareaType::class, [
                'label' => 'camp.desc_label',
                'attr' => [
                    'placeholder' => 'camp.desc_holder',
                ]
            ])

            ->add('category', EntityType::class, [
                'label' => 'category.name',
                'class' => Category::class,
                'choice_label' => 'name',
            ])
//            ->add('image', FileType::class, [
//                'label' => 'camp.image_label',
//                'attr' => [
//                    'placeholder' => 'camp.image_holder',
//                ]
//            ]);

            ->add('country', ChoiceType::class, [
                'choices' => [
                    'Belarus' => 'by_BE',
                    'Russian' => 'ru_RU',
                    'Ukraine' => 'uk_UA',
                ],
                'label' => 'camp.country_label',
            ])

            ->add('moneyPurpose', MoneyType::class, [
                'divisor' => 100,
                'label' => 'camp.moneyPurpose_label',
            ])

            ->add('finishedAt', DateTimeType::class, [
                'label' => 'camp.finishedAt_label',
            ])

            ->add('descriptionLong', CKEditorType::class, [
                'label' => 'camp.descLong_label',
            ])

            ->add('save', SubmitType::class, [
                'label' => 'camp.save',
                'attr' => ['class' => 'btn btn-success btn-lg mt-5 pl-auto'],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Crowdfunding::class,
        ]);
    }
}
