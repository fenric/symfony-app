<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Request\AllExportsRequest;
use App\Dto\Request\CreateExportRequest;
use App\Dto\Request\UpdateExportRequest;
use App\Dto\Response\ExportResponse;
use App\Entity\Export;
use App\Exception\EntityNotFoundException;
use App\Exception\UnprocessableEntityException;
use App\Exception\UntrackedEntityException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ExportService
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
     * @var DestinationService
     */
    private DestinationService $destinationService;

    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * Constructor of the class
     *
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @param DestinationService $destinationService
     * @param UserService $userService
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        DestinationService $destinationService,
        UserService $userService
    ) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->destinationService = $destinationService;
        $this->userService = $userService;
    }

    /**
     * Tries to create a new export by the given request
     *
     * @param CreateExportRequest $createExportRequest
     *
     * @return Export
     *
     * @throws EntityNotFoundException
     *         If an entity wasn't found.
     *
     * @throws UnprocessableEntityException
     *         If an entity isn't valid.
     */
    public function createExportFromRequest(CreateExportRequest $createExportRequest) : Export
    {
        $destination = $this->destinationService->getDestinationById($createExportRequest->getDestinationId());
        $createdBy = $this->userService->getUserById($createExportRequest->getCreatedById());

        $export = new Export();
        $export->setName($createExportRequest->getName());
        $export->setDestination($destination);
        $export->setCreatedBy($createdBy);

        $violations = $this->validator->validate($export);
        if ($violations->count() > 0) {
            throw new UnprocessableEntityException($violations);
        }

        $this->entityManager->persist($export);

        return $export;
    }

    /**
     * Tries to update the given export by the given request
     *
     * @param Export $export
     * @param UpdateExportRequest $updateExportRequest
     *
     * @return Export
     *
     * @throws UntrackedEntityException
     *         If an entity isn't tracked by ORM.
     *
     * @throws UnprocessableEntityException
     *         If an entity isn't valid.
     */
    public function updateExportFromRequest(Export $export, UpdateExportRequest $updateExportRequest) : Export
    {
        if (!$this->entityManager->contains($export)) {
            throw new UntrackedEntityException();
        }

        $destination = $this->destinationService->getDestinationById($updateExportRequest->getDestinationId());

        $export->setName($updateExportRequest->getName());
        $export->setDestination($destination);

        $violations = $this->validator->validate($export);
        if ($violations->count() > 0) {
            throw new UnprocessableEntityException($violations);
        }

        return $export;
    }

    /**
     * Tries to delete the given export
     *
     * @param Export $export
     *
     * @return void
     *
     * @throws UntrackedEntityException
     *         If an entity isn't tracked by ORM.
     */
    public function deleteExport(Export $export) : void
    {
        if (!$this->entityManager->contains($export)) {
            throw new UntrackedEntityException();
        }

        $this->entityManager->remove($export);
    }

    /**
     * Tries to get an export by the given ID
     *
     * @param string $id
     *
     * @return Export
     *
     * @throws EntityNotFoundException
     *         If an entity wasn't found.
     */
    public function getExportById(string $id) : Export
    {
        /** @var \App\Repository\ExportRepository */
        $exportRepository = $this->entityManager->getRepository(Export::class);

        $export = $exportRepository->find($id);
        if (!isset($export)) {
            throw new EntityNotFoundException();
        }

        return $export;
    }

    /**
     * Gets all exports
     *
     * @param AllExportsRequest|null $allExportsRequest
     *
     * @return list<Export>
     */
    public function getAllExports(?AllExportsRequest $allExportsRequest = null) : array
    {
        /** @var \App\Repository\ExportRepository */
        $exportRepository = $this->entityManager->getRepository(Export::class);

        return $exportRepository->getAllExports($allExportsRequest);
    }

    /**
     * Converts the given export to the response
     *
     * @param Export $export
     *
     * @return ExportResponse
     */
    public function convertExportToResponse(Export $export) : ExportResponse
    {
        $exportResponse = new ExportResponse();
        $exportResponse->setId($export->getId());
        $exportResponse->setName($export->getName());
        $exportResponse->setCreatedAt($export->getCreatedAt());

        $destination = $export->getDestination();
        if (isset($destination)) {
            $exportResponse->setDestination($this->destinationService
                ->convertDestinationToResponse($destination));
        }

        $createdBy = $export->getCreatedBy();
        if (isset($createdBy)) {
            $exportResponse->setCreatedBy($this->userService
                ->convertUserToResponse($createdBy));
        }

        return $exportResponse;
    }
}
