<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Repository\CategorieRepository;
use App\Repository\ProjetRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private ProjetRepository $projetRepository;
    private UserRepository $userRepository;
    private CategorieRepository $categorieRepository;


    public function __construct(
        UserRepository $userRepository,
        CategorieRepository $categorieRepository,
        ProjetRepository $projetRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->categorieRepository = $categorieRepository;
        $this->projetRepository = $projetRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(ProjetRepository $projetRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'projets' => $this->projetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/projet/{slug}", name="app_view_projet_user")
     */
    public function viewProjet(Projet $projet): Response
    {
        return $this->render('home/project.html.twig', [
            'projet' => $projet
        ]);
    }
}
