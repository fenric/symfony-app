<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Request\CreateUserRequest;
use App\Dto\Request\UpdateUserRequest;
use App\Dto\Response\UserResponse;
use App\Entity\User;
use App\Exception\EntityNotFoundException;
use App\Exception\UnprocessableEntityException;
use App\Exception\UntrackedEntityException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UserService
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * Constructor of the class
     *
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * Tries to create a new user by the given request
     *
     * @param CreateUserRequest $createUserRequest
     *
     * @return User
     *
     * @throws UnprocessableEntityException
     *         If an entity isn't valid.
     */
    public function createUserFromRequest(CreateUserRequest $createUserRequest) : User
    {
        $user = new User();
        $user->setName($createUserRequest->getName());

        $violations = $this->validator->validate($user);
        if ($violations->count() > 0) {
            throw new UnprocessableEntityException($violations);
        }

        $this->entityManager->persist($user);

        return $user;
    }

    /**
     * Tries to update the given user by the given request
     *
     * @param User $user
     * @param UpdateUserRequest $updateUserRequest
     *
     * @return User
     *
     * @throws UntrackedEntityException
     *         If an entity isn't tracked by ORM.
     *
     * @throws UnprocessableEntityException
     *         If an entity isn't valid.
     */
    public function updateUserFromRequest(User $user, UpdateUserRequest $updateUserRequest) : User
    {
        if (!$this->entityManager->contains($user)) {
            throw new UntrackedEntityException();
        }

        $user->setName($updateUserRequest->getName());

        $violations = $this->validator->validate($user);
        if ($violations->count() > 0) {
            throw new UnprocessableEntityException($violations);
        }

        return $user;
    }

    /**
     * Tries to delete the given user
     *
     * @param User $user
     *
     * @return void
     *
     * @throws UntrackedEntityException
     *         If an entity isn't tracked by ORM.
     */
    public function deleteUser(User $user) : void
    {
        if (!$this->entityManager->contains($user)) {
            throw new UntrackedEntityException();
        }

        $this->entityManager->remove($user);
    }

    /**
     * Tries to get an user by the given ID
     *
     * @param string $id
     *
     * @return User
     *
     * @throws EntityNotFoundException
     *         If an entity wasn't found.
     */
    public function getUserById(string $id) : User
    {
        /** @var \App\Repository\UserRepository */
        $userRepository = $this->entityManager->getRepository(User::class);

        $user = $userRepository->find($id);
        if (!isset($user)) {
            throw new EntityNotFoundException();
        }

        return $user;
    }

    /**
     * Gets all users
     *
     * @return list<User>
     */
    public function getAllUsers() : array
    {
        /** @var \App\Repository\UserRepository */
        $userRepository = $this->entityManager->getRepository(User::class);

        return $userRepository->findAll();
    }

    /**
     * Converts the given user to the response
     *
     * @param User $user
     *
     * @return UserResponse
     */
    public function convertUserToResponse(User $user) : UserResponse
    {
        $userResponse = new UserResponse();
        $userResponse->setId($user->getId());
        $userResponse->setName($user->getName());

        return $userResponse;
    }
}
