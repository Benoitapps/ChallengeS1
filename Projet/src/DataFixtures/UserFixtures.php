<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // PWD = test
        $pwd = '$2y$13$wiWVplNfdpwyWjWFdTtY..TQvVVHDVkv/PEUtf7dSlvmC2KiqlJHq';

        $companies = $manager->getRepository(Company::class)->findAll();


        $object = (new User())
            ->setEmail('user@user.fr')
            ->setPassword($pwd)
            ->setRoles([])
            ->setIsVerified(0)
        ;
        $manager->persist($object);

        $object = (new User())
            ->setEmail('admin@user.fr')
            ->setPassword($pwd)
            ->setRoles(["ROLE_ADMIN"])
            ->setIsVerified(0)
        ;
        $manager->persist($object);

        $object = (new User())
            ->setEmail('company@user.fr')
            ->setPassword($pwd)
            ->setRoles(["ROLE_COMPANY"])
            ->setIsVerified(0)
            ->setCompany($faker->randomElement($companies))
        ;
        $manager->persist($object);

        $manager->flush();
    }
}
