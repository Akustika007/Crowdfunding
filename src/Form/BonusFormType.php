<?php


namespace App\Form;


use App\Entity\Bonus;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BonusFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'bonus.name_label',
            'attr' => [
                'placeholder' => 'bonus.name_holder',
            ],
        ])

        ->add('description', CKEditorType::class, [
            'label' => 'bonus.desc_label',
            'attr' => [
                'placeholder' => 'bonus.desc_holder',
            ]
        ])

        ->add('price', MoneyType::class)

        ->add('save', SubmitType::class, [
        'label' => 'bonus.save',
    ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bonus::class,
        ]);
    }
}