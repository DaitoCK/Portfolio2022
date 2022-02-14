<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ContactType;
use App\Repository\CounterRepository;
use App\Repository\ProjetRepository;
use App\Service\Mailer\MailerServiceInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    private ProjetRepository $projetRepository;
    private CounterRepository $counterRepository;


    public function __construct(
        ProjetRepository $projetRepository,
        CounterRepository $counterRepository
    )
    {
        $this->projetRepository = $projetRepository;
        $this->counterRepository = $counterRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, MailerServiceInterface $mailer): Response
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $toAdress = [new Address('contact@kendhal-cayrel.fr')];
            $mailer->send(
                $data['mail'],
                $toAdress,
                $data['subject'],
                'emails/contact.mjml.twig',
                'emails/contact.txt.twig',
                [
                    'name' => $data['name'],
                    'mail' => $data['mail'],
                    'subject' => $data['subject'],
                    'message' => $data['message']
                ]
            );
            return $this->redirectToRoute('home');
        }

        return $this->render('home/index.html.twig', [
            'projets' => $this->projetRepository->findAll(),
            'form' => $form->createView(),
            'counters' => $this->counterRepository->findAll(),
        ]);

    }

    /**
     * @Route("/projet/{slug}", name="app_view_projet_user")
     */
    public function viewProjet(Projet $projet): Response
    {
        return $this->render('home/project.html.twig', [
            'projet' => $projet,
            'counters' => $this->counterRepository->findAll(),
        ]);
    }

}
