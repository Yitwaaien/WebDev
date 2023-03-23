<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Builder\Class_;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use League\Bundle\OAuth2ServerBundle\Event\UserResolveEvent;

final class UserResolveListener
{


    public function __construct(private EntityManagerInterface $entityManager, private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function onUserResolve(UserResolveEvent $event): void
    {

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $event->getUsername()]);

        if(!$user) {
            throw  new AuthenticationCredentialsNotFoundException('invalid email', Response::HTTP_NOT_FOUND);
        }



        if (!$this->passwordHasher->isPasswordValid($user, $event->getPassword())) {
            throw  new AuthenticationCredentialsNotFoundException('invalid password', Response::HTTP_NOT_FOUND);
        }

        $event->setUser($user);
    }
}