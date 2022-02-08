<?php

namespace App\Command;

use App\Repository\ContactRepository;
use App\Repository\UserRepository;
use App\Service\ContactService;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Email;



class SendContactCommand extends Command
{
    private ContactRepository $contactRepository;
    private MailerInterface $mailer;
    private ContactService $contactService;
    private UserRepository $userRepository;
    protected static $defaultName = 'app:send-contact';

    public function __construct(
     ContactRepository $contactRepository,
     MailerInterface $mailer,
     ContactService $contactService,
     UserRepository $userRepository
    ) {
      $this->contactRepository = $contactRepository;
      $this->mailer = $mailer;
      $this->contactService = $contactService;
      $this->userRepository = $userRepository;
      parent::__construct();
      }

    /**
     * @throws NonUniqueResultException
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output)
      {
          $toSend = $this->contactRepository->findBy(['isSend' => false]);
          $adress = new Address($this->userRepository->getProjet()->getEmail(), $this->userRepository->getProjet()->getNom() . ''. $this->userRepository->getProjet()->getPrenom());

          foreach ($toSend as $mail) {
              $email = (new Email())
                  ->form($mail->getEmail())
                  ->to($adress)
                  ->subject('Nouveau message de ' . $mail->getNom())
                  ->text($mail->getMessage());
              $this->mailer->send($email);

              $this->contactService->isSend($mail);
          }

          return Command::SUCCESS;
      }
}