<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Anime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        //handle users
    
        $user = new User();
        $user->setUsername('kenta')
              ->setPassword($this->encoder->encodePassword($user, 'password'))
              ->setEmail('birna.gerald@gmail.com')
              ->setRoles(['ROLE_ADMIN'])
              ->setEnable(true);

        $manager->persist($user);
        
        // handle ads
        for ($i = 1; $i <= 5; $i++){

            $anime = new Anime();
            $anime->setTitle($faker->words($nb = 3, $asText = true) )
                  ->setTotalEpisode($faker->numberBetween($min = 12, $max = 24))
                  ->setCoverImage('http://lorempixel.com/650/350')
                  ->setOwner($user);
            $manager->persist($anime);
        }

        $manager->flush();
    }
}
