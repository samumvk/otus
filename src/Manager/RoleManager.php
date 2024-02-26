<?php

namespace App\Manager;

use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;

class RoleManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private RoleRepository $roleRepository,
    )
    {

    }
    public function getRoleById($roleId)
    {
        return $this->roleRepository->findOneBy(array(
            'id' => $roleId
        ));
    }
}