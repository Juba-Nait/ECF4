<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class UsersFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder
    ) {
    }


    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setemail('juba@hotmail.fr');
        $admin->setLastname('Nait rabah');
        $admin->setFirstname('Juba');
        $admin->setAddress('427 rue André le Notre');
        $admin->setZipcode('34080');
        $admin->setCity('Montpellier');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, 'azerty')
        );
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $faker = Faker\Factory::create('fr_FR');

        for ($usr = 1; $usr <= 5; $usr++) {
            $user = new Users();
            $user->setemail($faker->email);
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setAddress($faker->streetAddress);
            $user->setZipcode($faker->postcode);
            $user->setCity($faker->city);
            $user->setPassword(
                $this->passwordEncoder->hashPassword($admin, 'secret')
            );

            $manager->persist($user);
        }

        $manager->flush();
    }
}
