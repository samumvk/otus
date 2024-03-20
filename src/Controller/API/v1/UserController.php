<?php

namespace App\Controller\API\v1;

use App\Entity\User;
use App\Manager\RoleManager;
use App\Manager\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(path: '/api/v1/user')]
class UserController extends AbstractController
{

    public function __construct(
        private readonly UserManager $userManager,
        private readonly RoleManager $roleManager
    ) {
    }

    #[Route(path: '', methods: ['GET'])]
    public function getUsers(Request $request): Response
    {
        $users = $this->userManager->getAllUsers();

        return new JsonResponse(['users' => array_map(static fn(User $user) => $user->toArray(), $users)], Response::HTTP_OK);
    }

    #[Route(path: '/{user_id}', requirements: ['user_id' => '\d+'], methods: ['GET'])]
    #[Entity('user', expr: 'repository.find(user_id)')]
    public function getUserById(User $user): Response
    {
        return new JsonResponse($user->toArray(), Response::HTTP_OK);
    }

    #[Route(path: '', methods: ['POST'])]
    public function saveUser(Request $request, ValidatorInterface $validator): Response
    {
        $name = $request->request->get('name');
        $password = $request->request->get('password');
        $login = $request->request->get('login');
        $roleId = $request->request->get('roleId');
        $role = $this->roleManager->getRoleById($roleId);

        $user = $this->userManager->saveUser($name, $login, $password, $role, $validator);

        return new JsonResponse($user->toArray(), Response::HTTP_OK);
    }

    #[Route(path: '/{userId}', requirements: ['user_id' => '\d+'], methods: ['POST'])]
    public function updateUser(int $userId, User $user, Request $request, ValidatorInterface $validator): Response
    {
        $name = $request->request->get('name');
        $password = $request->request->get('password');
        $login = $request->request->get('login');

        $roleId = $request->request->get('roleId');
        $role = $this->roleManager->getRoleById($roleId);



        $user = $this->userManager->saveUser($name, $login, $password, $role, $validator, $userId);

        return new JsonResponse($user->toArray(), Response::HTTP_OK);
    }

    #[Route(path: '/{user_id}', requirements: ['user_id' => '\d+'], methods: ['DELETE'])]
    #[Entity('user', expr: 'repository.find(user_id)')]
    public function deleteUserAction(User $user): Response
    {
        $result = $this->userManager->deleteUser($user);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

}