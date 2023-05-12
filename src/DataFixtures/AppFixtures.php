<?php

namespace App\DataFixtures;

use App\Entity\Gateau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();

        /**for ($i=0;$i<10;$i++){
            $gateau = new Gateau();
            $gateau->setName($faker->name());
            $gateau->setDescription($faker->text());
            $manager->persist($gateau);
        }**/


        $manager->flush();
    }
}
