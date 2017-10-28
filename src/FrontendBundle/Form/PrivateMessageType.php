<?php

namespace FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PrivateMessageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', TextType::class, [
                'label' => 'Mensage',
                'required' => 'required',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('image', TextType::class, [
                'label' => 'Imagen',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('file', TextType::class, [
                'label' => 'Archivo',
                'required' => 'required',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('Enviar', SubmitType::class, [
                'attr' => [
                    "class" => "btn btn-success"
                ]
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\PrivateMessage'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backendbundle_user';
    }


}
