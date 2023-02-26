<?php

namespace App\Form;

use App\Entity\RequestCompany;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class RequestCompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom de l\'entreprise',
            ])
            ->add('siren', null, [
                'attr' => [
                    'maxlength' => 9,
                    'minlength' => 9,
                    'pattern' => '[0-9]*' // autoriser que les chiffres
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d+$/', // vérifier que le champ ne contient que des chiffres
                        'message' => 'Le champ ne doit contenir que des chiffres.'
                    ])
                ],
                'label' => 'SIREN',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RequestCompany::class,
        ]);
    }
}