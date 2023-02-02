<?php

namespace App\Form;

use App\Entity\Airport;
use App\Entity\Annonce;
use App\Entity\Composition;
use App\Entity\Date;
use App\Entity\User;
use App\Repository\DateRepository;

use Doctrine\DBAL\Types\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix')

            ->add('dateDepartAller',DateTimeType::class,[
                'widget' => "single_text",
            ])
            ->add('dateDepartArriver',DateTimeType::class,[
                'widget' => "single_text",
            ])

            ->add('airportDepartAller',EntityType::class,[
                'class' => Airport::class,
                'choice_label' => 'name',
            ])

            ->add('airportDepartArriver',EntityType::class,[
                'class' => Airport::class,
                'choice_label' => 'name',
            ])

            ->add('dateRetourAller',DateTimeType::class,[
                'widget' => "single_text",
            ])
            ->add('dateRetourArriver',DateTimeType::class,[
                'widget' => "single_text",
            ])

            ->add('airportRetourAller',EntityType::class,[
                'class' => Airport::class,
                'choice_label' => 'name',
            ])
            ->add('airportRetourArriver',EntityType::class,[
                'class' => Airport::class,
                'choice_label' => 'name',
            ])
            ->add('composition',EntityType::class,[
                'class' => Composition::class,
                'choice_label' => 'id',
            ])
            ->add('client',EntityType::class,[
                'class' => User::class,
                'choice_label' => 'email',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
