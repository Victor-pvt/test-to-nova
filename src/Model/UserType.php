<?php

/**
 * Created by PhpStorm.
 * User: victor
 * Date: 07.08.16
 * Time: 15:06
 */

namespace Model;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class,[
                'label' => 'Введите имя',
                'required' => true,
//                'constraints' => [
//                    new NotBlank(),
//                    new Length(array('min' => 5)),
//                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Введите пароль',
                'required' => true,
 //               'constraints' => [
 //                   new NotBlank(),
 //                   new Length(array('min' => 5)),
 //               ],
            ])
            ->add('password_repeat', PasswordType::class, [
                'label' => 'Повторите пароль',
                'required' => false,
//                'constraints' => [
//                    new NotBlank(),
//                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Введите email',
                'required' => false,
 //               'constraints' => [
 //                   new NotBlank(),
 //               ],
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Model\User'
        ));
    }
}
 