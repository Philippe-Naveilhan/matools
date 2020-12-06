<?php

namespace App\Form;

use App\Entity\Evalcompetence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EvalcompetenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextareaType::class, [
                'label' => ' ',
                'attr' => ['rows'=>'3', 'class'=>'h-100px'],
            ])
            ->add('placeorder', null, [
                'label' => 'order',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evalcompetence::class,
        ]);
    }
}
