<?php


namespace App\Security;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserConfirmationService
{
    private $userRepository;
    private $entityManager;
    private $logger;

    public function __construct(UserRepository $userRepository,
                                EntityManagerInterface $entityManager,
                                LoggerInterface $logger)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function confirmUser(string $confirmationToken)
    {
        $this->logger->debug('Fetching user by confirmation token');

        /** @var User $user */
        $user = $this->userRepository->findOneBy(['confirmationToken' => $confirmationToken]);

        if (!$user) {
            $this->logger->debug('User not found');
            throw new NotFoundHttpException();
        }

        $user->setEnabled(true);
        $user->setConfirmationToken(null);
        $this->entityManager->flush();
    }
}