<?php

namespace App\DataFixtures;

use App\Entity\Anime;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        // handle ads
        for ($i = 1; $i <= 5; $i++){

            $anime = new Anime();
            $anime->setTitle($faker->words($nb = 3, $asText = true) )
                  ->setTotalEpisode($faker->numberBetween($min = 12, $max = 24))
                  ->setCoverImage('http://lorempixel.com/650/350');

            $manager->persist($anime);
        }

        $manager->flush();
    }
}
