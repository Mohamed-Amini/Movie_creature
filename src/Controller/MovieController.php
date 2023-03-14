<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    // private $em;
    // public function __construct(EntityManagerInterface $em){
    //     $this->em =$em;
    // }

    #[Route('/movie', methods:['GET'] ,name: 'app_movie')]
    public function index(): Response
    {

        // findAll() - SELECT * FROM movies;
        // find() - SELECT * FROM movies WHERE id = 5;
        // findBy() -  SELECT * FROM movies ORDER BY id DESC
        // findOneBy() - SELECT * FROM movies Where id = 9 and title = Gladiator if one these ain't correct the return value will be null and we did order the ID  DESC
        // count() - SELECT * From movies where id = 1 if you didn't spesify it will give you how many column you got in ur movies .
        // getClassName(): - it gives you the path or location of the class ur working with 

        // $repository = $this->em->getRepository(Movie::class);


        // $movies = $repository->findAll();

        // dd($movies);

        return $this->render('movie/index.html.twig');
    }
}