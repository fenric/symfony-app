<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Request\CreateDestinationRequest;
use App\Dto\Request\UpdateDestinationRequest;
use App\Dto\Response\DestinationResponse;
use App\Entity\Destination;
use App\Exception\EntityNotFoundException;
use App\Exception\UnprocessableEntityException;
use App\Exception\UntrackedEntityException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class DestinationService
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
     * Tries to create a new destination by the given request
     *
     * @param CreateDestinationRequest $createDestinationRequest
     *
     * @return Destination
     *
     * @throws UnprocessableEntityException
     *         If an entity isn't valid.
     */
    public function createDestinationFromRequest(CreateDestinationRequest $createDestinationRequest) : Destination
    {
        $destination = new Destination();
        $destination->setName($createDestinationRequest->getName());

        $violations = $this->validator->validate($destination);
        if ($violations->count() > 0) {
            throw new UnprocessableEntityException($violations);
        }

        $this->entityManager->persist($destination);

        return $destination;
    }

    /**
     * Tries to update the given destination by the given request
     *
     * @param Destination $destination
     * @param UpdateDestinationRequest $updateDestinationRequest
     *
     * @return Destination
     *
     * @throws UntrackedEntityException
     *         If an entity isn't tracked by ORM.
     *
     * @throws UnprocessableEntityException
     *         If an entity isn't valid.
     */
    public function updateDestinationFromRequest(
        Destination $destination,
        UpdateDestinationRequest $updateDestinationRequest
    ) : Destination {
        if (!$this->entityManager->contains($destination)) {
            throw new UntrackedEntityException();
        }

        $destination->setName($updateDestinationRequest->getName());

        $violations = $this->validator->validate($destination);
        if ($violations->count() > 0) {
            throw new UnprocessableEntityException($violations);
        }

        return $destination;
    }

    /**
     * Tries to delete the given destination
     *
     * @param Destination $destination
     *
     * @return void
     *
     * @throws UntrackedEntityException
     *         If an entity isn't tracked by ORM.
     */
    public function deleteDestination(Destination $destination) : void
    {
        if (!$this->entityManager->contains($destination)) {
            throw new UntrackedEntityException();
        }

        $this->entityManager->remove($destination);
    }

    /**
     * Tries to get a destination by the given ID
     *
     * @param string $id
     *
     * @return Destination
     *
     * @throws EntityNotFoundException
     *         If an entity wasn't found.
     */
    public function getDestinationById(string $id) : Destination
    {
        /** @var \App\Repository\DestinationRepository */
        $destinationRepository = $this->entityManager->getRepository(Destination::class);

        $destination = $destinationRepository->find($id);
        if (!isset($destination)) {
            throw new EntityNotFoundException();
        }

        return $destination;
    }

    /**
     * Gets all destinations
     *
     * @return list<Destination>
     */
    public function getAllDestinations() : array
    {
        /** @var \App\Repository\DestinationRepository */
        $destinationRepository = $this->entityManager->getRepository(Destination::class);

        return $destinationRepository->findAll();
    }

    /**
     * Converts the given destination to the response
     *
     * @param Destination $destination
     *
     * @return DestinationResponse
     */
    public function convertDestinationToResponse(Destination $destination) : DestinationResponse
    {
        $destinationResponse = new DestinationResponse();
        $destinationResponse->setId($destination->getId());
        $destinationResponse->setName($destination->getName());

        return $destinationResponse;
    }
}
