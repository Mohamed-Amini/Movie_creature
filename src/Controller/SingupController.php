<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SingupController extends AbstractController
{
    #[Route('/singup', name: 'app_singup')]
    public function index(): Response
    {

        $movies = ["avengers: Endgame", "inseption","hmida ras mida ", "kalbon" ];


        return $this->render('singup/index.html.twig', array(
            'movies' => $movies
        ));
    }
}