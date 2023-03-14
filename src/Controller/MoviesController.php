<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Movie;
use App\Form\MovieFormType;
use Symfony\Component\HttpFoundation\Request;


class MoviesController extends AbstractController
{
    
    private $em;
    private $movieRepository;

    private $actorRepository;
    public function __construct(MovieRepository $movieRepository, EntityManagerInterface  $em){
        $this->movieRepository = $movieRepository;
        $this->em = $em;

    }


    // home page of Movies 

    #[Route('/movies' , methods:['GET'], name: 'movies')]
    public function index(): Response
    {
        $movies = $this->movieRepository->findAll();
        
        return $this->render('movies/index.html.twig',[
            'movies' => $movies
        ]);
    }



    // Creating a movie 

    #[Route('/movies/create', name:'create_movie')]
    public function create(Request $request): Response{
        $movie = new Movie();
        $form = $this->createForm(MovieFormType::class , $movie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $newMovie = $form->getData();   

            $imagePath = $form->get('imagePath')->getData();
            if($imagePath){
                $newFileName = uniqid() . '.' . $imagePath->guessExtension();
                try{
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads' ,
                        $newFileName
                    );
                } catch(FileException $e) {
                    return new Response($e->getMessage());
                }

                $newMovie->setImagePath('/uploads/' . $newFileName);
            }
            $this->em->persist($newMovie);
            $this->em->flush();
            
            return $this->redirectToRoute('movies');
            
        }
        
        return $this->render('movies/create.html.twig',[
            'form' => $form->createView()
        ]);
    }
    
    // The show page of movie 

    #[Route('/movies/{id}', methods:['GET'])]
    public function show($id): Response
    {
        $movie = $this->movieRepository->find($id);
    
        return $this->render('movies/show.html.twig',[
            'movie' => $movie,
        ]);
    }
        // Deleting a movie 

        #[Route('/movies/delete/{id}' , methods:['GET', 'DELETE'] , name:'movie_delete')]
        public function delete($id): Response{
            
            $movie = $this->movieRepository->find($id);
            $this->em->remove($movie);
            $this->em->flush();
    
    
            return $this->redirectToRoute('movies');
        } 
    


    // Editing the movie
    #[Route('/movies/edit/{id}' ,name: 'edit_movie')]
    public function edit($id, Request $request): Response{
    
        $movie = $this->movieRepository->find($id);
        $form = $this->createForm(MovieFormType::class, $movie);
    
        $form->handleRequest($request);
        $imagePath = $form->get('imagePath')->getData();
    
        if($form->isSubmitted() && $form->isValid()){
    
            if($imagePath){
                // handle image upload
                $oldImagePath = $movie->getImagePath();
                if($oldImagePath !== null){
                    $oldImagePath = $this->getParameter('kernel.project_dir') . '/public' . $oldImagePath;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
    
                $newFilename = uniqid() . '.' . $imagePath->guessExtension();
    
                try{
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads' ,
                        $newFilename
                    );
                } catch(FileException $e) {
                    return new Response($e->getMessage());
                }
    
                $movie->setImagePath('/uploads/' . $newFilename);
                $this->em->flush();
    
                return $this->redirectToRoute('movies');
    
            }else {
                $movie->setTitle($form->get('title')->getData());
                $movie->setReleaseYear($form->get('releaseYear')->getData());
                $movie->setDescription($form->get('description')->getData());
    
                $this->em->flush();
                return $this->redirectToRoute('movies');
            }
        } 
    
        return $this->render('/movies/edit.html.twig',[
            'movie' => $movie,
            'form' => $form->createView()
        ]);
    }
}