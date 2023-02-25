<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_COMPANY' => 'ROLE_COMPANY',
                    'ROLE_USER' => 'ROLE_USER',
                ],
                'choice_label' => function ($value, $key, $index) {
                    return $value;
                },
                'data' => implode(',', $options['data']->getRoles()), // convertir les rôles en chaîne
            ])
            ->add('isVerified')
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}