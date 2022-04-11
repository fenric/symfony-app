<?php

declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\Dto\Request\CreateDestinationRequest;
use App\Dto\Request\UpdateDestinationRequest;
use App\Service\SerializationService;
use App\Service\DestinationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class DestinationController
{

    /**
     * @var SerializationService
     */
    private SerializationService $serializationService;

    /**
     * @var DestinationService
     */
    private DestinationService $destinationService;

    /**
     * Constructor of the class
     *
     * @param SerializationService $serializationService
     * @param DestinationService $destinationService
     */
    public function __construct(
        SerializationService $serializationService,
        DestinationService $destinationService
    ) {
        $this->serializationService = $serializationService;
        $this->destinationService = $destinationService;
    }

    /**
     * @Route(
     *   path="/api/v1/destination",
     *   name="api_v1_destination_create",
     *   methods="POST"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createDestinationAction(Request $request) : JsonResponse
    {
        $createDestinationRequest = $this->serializationService->hydrateObject(
            CreateDestinationRequest::class,
            $request->request->all()
        );

        $destination = $this->destinationService->createDestinationFromRequest($createDestinationRequest);
        $destinationDto = $this->destinationService->convertDestinationToResponse($destination);

        return new JsonResponse($destinationDto);
    }

    /**
     * @Route(
     *   path="/api/v1/destination/{destination_id}",
     *   name="api_v1_destination_read",
     *   methods="GET"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function readDestinationAction(Request $request) : JsonResponse
    {
        $destination = $this->destinationService->getDestinationById($request->attributes->get('destination_id'));
        $destinationDto = $this->destinationService->convertDestinationToResponse($destination);

        return new JsonResponse($destinationDto);
    }

    /**
     * @Route(
     *   path="/api/v1/destination/{destination_id}",
     *   name="api_v1_destination_update",
     *   methods="PATCH"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function updateDestinationAction(Request $request) : JsonResponse
    {
        $destination = $this->destinationService->getDestinationById($request->attributes->get('destination_id'));

        $updateDestinationRequest = $this->serializationService->hydrateObject(
            UpdateDestinationRequest::class,
            $request->request->all()
        );

        $destination = $this->destinationService->updateDestinationFromRequest($destination, $updateDestinationRequest);
        $destinationDto = $this->destinationService->convertDestinationToResponse($destination);

        return new JsonResponse($destinationDto);
    }

    /**
     * @Route(
     *   path="/api/v1/destination/{destination_id}",
     *   name="api_v1_destination_delete",
     *   methods="DELETE"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function deleteDestinationAction(Request $request) : JsonResponse
    {
        $destination = $this->destinationService->getDestinationById($request->attributes->get('destination_id'));
        $this->destinationService->deleteDestination($destination);

        return new JsonResponse();
    }

    /**
     * @Route(
     *   path="/api/v1/destination",
     *   name="api_v1_destination_all",
     *   methods="GET"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function allDestinationsAction(Request $request) : JsonResponse
    {
        $destinations = $this->destinationService->getAllDestinations();

        $destinationDtos = [];
        foreach ($destinations as $destination) {
            $destinationDtos[] = $this->destinationService->convertDestinationToResponse($destination);
        }

        return new JsonResponse($destinationDtos);
    }
}
