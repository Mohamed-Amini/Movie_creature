<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Movie;


class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movie = new Movie();
        $movie->setTitle('Gladiator 2 ');
        $movie->setReleaseYear('2023');
        $movie->setDescription('This is a Description about Gladiator');
        $movie->setImagePath('https://musicart.xboxlive.com/7/f0951400-0000-0000-0000-000000000002/504/image.jpg?w=1920&h=1080');

        //Adding data to pivote table movie_actor table
        $movie->addActor($this->getReference('actor_1'));
        // end 

        $manager->persist($movie);


        $movie2 = new Movie();
        $movie2->setTitle('The dark knight');
        $movie2->setReleaseYear('2008');
        $movie2->setDescription('This is a Description about The dark Knight');
        $movie2->setImagePath('https://contentserver.com.au/assets/598411_p173378_p_v8_au.jpg');

        // Adding data to pivote table movie_actor table
        $movie2->addActor($this->getReference('actor_3'));
        $movie2->addActor($this->getReference('actor_4'));
        // end 



        $manager->persist($movie2);

        
        $manager->flush();
    }
}




        