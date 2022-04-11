<?php

declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\Dto\Request\CreateUserRequest;
use App\Dto\Request\UpdateUserRequest;
use App\Service\SerializationService;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class UserController
{

    /**
     * @var SerializationService
     */
    private SerializationService $serializationService;

    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * Constructor of the class
     *
     * @param SerializationService $serializationService
     * @param UserService $userService
     */
    public function __construct(
        SerializationService $serializationService,
        UserService $userService
    ) {
        $this->serializationService = $serializationService;
        $this->userService = $userService;
    }

    /**
     * @Route(
     *   path="/api/v1/user",
     *   name="api_v1_user_create",
     *   methods="POST"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createUserAction(Request $request) : JsonResponse
    {
        $createUserRequest = $this->serializationService->hydrateObject(
            CreateUserRequest::class,
            $request->request->all()
        );

        $user = $this->userService->createUserFromRequest($createUserRequest);
        $userDto = $this->userService->convertUserToResponse($user);

        return new JsonResponse($userDto);
    }

    /**
     * @Route(
     *   path="/api/v1/user/{user_id}",
     *   name="api_v1_user_read",
     *   methods="GET"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function readUserAction(Request $request) : JsonResponse
    {
        $user = $this->userService->getUserById($request->attributes->get('user_id'));
        $userDto = $this->userService->convertUserToResponse($user);

        return new JsonResponse($userDto);
    }

    /**
     * @Route(
     *   path="/api/v1/user/{user_id}",
     *   name="api_v1_user_update",
     *   methods="PATCH"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function updateUserAction(Request $request) : JsonResponse
    {
        $user = $this->userService->getUserById($request->attributes->get('user_id'));

        $updateUserRequest = $this->serializationService->hydrateObject(
            UpdateUserRequest::class,
            $request->request->all()
        );

        $user = $this->userService->updateUserFromRequest($user, $updateUserRequest);
        $userDto = $this->userService->convertUserToResponse($user);

        return new JsonResponse($userDto);
    }

    /**
     * @Route(
     *   path="/api/v1/user/{user_id}",
     *   name="api_v1_user_delete",
     *   methods="DELETE"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function deleteUserAction(Request $request) : JsonResponse
    {
        $user = $this->userService->getUserById($request->attributes->get('user_id'));
        $this->userService->deleteUser($user);

        return new JsonResponse();
    }

    /**
     * @Route(
     *   path="/api/v1/user",
     *   name="api_v1_user_all",
     *   methods="GET"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function allUsersAction(Request $request) : JsonResponse
    {
        $users = $this->userService->getAllUsers();

        $userDtos = [];
        foreach ($users as $user) {
            $userDtos[] = $this->userService->convertUserToResponse($user);
        }

        return new JsonResponse($userDtos);
    }
}
