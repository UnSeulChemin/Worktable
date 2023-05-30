<?php

namespace App\Form;

use App\Entity\Css;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CssEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, options:[
                'attr' => [
                    'minlength' => '3',
                    'maxlength' => '30'
                ],
                'label' => 'Nom'
            ])
            ->add('submit', SubmitType::class, options:[
                'attr' => [
                    'class' => 'button-send'
                ],
                'label' => 'Modifier',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Css::class,
        ]);
    }
}
