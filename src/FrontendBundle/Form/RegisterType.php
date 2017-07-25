<?php

namespace FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RegisterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nombre',
                'required' => 'required',
                'attr' => [
                    'class' => 'form-name form-control'
                ]
            ])
            ->add('surname', TextType::class, [
                'label' => 'Apellidos',
                'required' => 'required',
                'attr' => [
                    'class' => 'form-surname form-control'
                ]
            ])
            ->add('nick', TextType::class, [
                'label' => 'Nick',
                'required' => 'required',
                'attr' => [
                    'class' => 'form-nick form-control nick-input'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo electrónico',
                'required' => 'required',
                'attr' => [
                    'class' => 'form-email form-control'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Contraseña',
                'required' => 'required',
                'attr' => [
                    'class' => 'form-password form-control'
                ]
            ])
            ->add('Registrarse', SubmitType::class, [
                'attr' => [
                    "class" => "form-submit btn btn-success"
                ]
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\User'
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
