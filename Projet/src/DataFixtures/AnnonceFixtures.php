<?php

namespace App\DataFixtures;

use App\Entity\Airport;
use App\Entity\Annonce;
use App\Entity\City;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\DBAL\Types\DateType;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class AnnonceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $airport = $manager->getRepository(Airport::class)->findAll();
        $user = $manager->getRepository(User::class)->findAll();
        $dateTime = new \DateTime();
        $dateTime->modify('+4 days');

        for ($i=0; $i<10; $i++) {
            $object = (new Annonce())
                ->setDateAnnonce($dateTime)

                ->setAirportDepartAller($faker->randomElement($airport))
                ->setAirportDepartArriver($faker->randomElement($airport))
                ->setAirportRetourAller($faker->randomElement($airport))
                ->setAirportRetourArriver($faker->randomElement($airport))

                ->setDateDepartAller($faker->dateTime)
                ->setDateDepartArriver($faker->dateTime)
                ->setDateRetourAller($faker->dateTime)
                ->setDateRetourArriver($faker->dateTime)

                ->setClient($faker->randomElement($user))
                ->setPrix(random_int(1,100))
                ->setPlace(random_int(1,100))

            ;
            $manager->persist($object);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AirportFixtures::class,
            UserFixtures::class
        ];
    }
}
