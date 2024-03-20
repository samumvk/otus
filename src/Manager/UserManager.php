<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserManager
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserRepository   $userRepository

    )
    {
    }
    public function getAllUsers():array
    {
        $repository = $this->entityManager->getRepository(User::class);
        return $repository->findAll();
    }

    public function getUserById($userId) : User
    {
        return $this->userRepository->findOneBy(
            array(
                    'id' => $userId
            )
        );
    }

    public function saveUser($name, $login, $password, $role, ValidatorInterface $validator, $userId = null ):User
    {
        if ($userId == null) {
            $user =  new User();
            $user->setCreatedAt(new DateTimeImmutable());
        } else {
            $user = $this->getUserById($userId);
        }

        $user->setName($name);
        $user->setLogin($login);
        $user->setPassword($password);
        $user->setRole($role);

        $user->setUpdatedAt(new DateTimeImmutable());

        if (!$validator->validate($user))
            return new User();

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    function deleteUser(?User $user): bool
    {
        if ($user == null) {
            return false;
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return true;
    }
}