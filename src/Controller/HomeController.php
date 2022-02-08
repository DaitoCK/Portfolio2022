<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Projet;
use App\Form\ContactType;
use App\Repository\CategorieRepository;
use App\Repository\ProjetRepository;
use App\Repository\UserRepository;
use App\Service\ContactService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
    public function index(ProjetRepository $projetRepository, Request $request, ContactService $contactService): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $contactService->persistContact($contact);

            return $this->redirectToRoute('home');
        }

        return $this->render('home/index.html.twig', [
            'projets' => $this->projetRepository->findAll(),
            'form' => $form->createView()
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
