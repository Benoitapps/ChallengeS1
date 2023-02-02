<?php

namespace App\DataFixtures;

use App\Entity\Airport;
use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AirportFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $cities = $manager->getRepository(City::class)->findAll();

        for ($i=0; $i<10; $i++) {
            $object = (new Airport())
                ->setName($faker->streetName)
                ->setCity($faker->randomElement($cities))
            ;
            $manager->persist($object);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CityFixtures::class
        ];
    }
}
