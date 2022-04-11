<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\Request\AllExportsRequest;
use App\Entity\Export;

final class ExportRepository extends AbstractRepository
{

    /**
     * Gets all exports
     *
     * @param AllExportsRequest|null $allExportsRequest
     *
     * @return list<Export>
     */
    public function getAllExports(?AllExportsRequest $allExportsRequest = null) : array
    {
        if (!isset($allExportsRequest)) {
            return $this->findAll();
        }

        $queryBuilder = $this->createQueryBuilder('export');

        $createdAtFrom = $allExportsRequest->getCreatedAtFrom();
        if (isset($createdAtFrom)) {
            $queryBuilder->andWhere('export.createdAt >= :createdAtFrom');
            $queryBuilder->setParameter('createdAtFrom', $createdAtFrom);
        }

        $createdAtUntil = $allExportsRequest->getCreatedAtUntil();
        if (isset($createdAtUntil)) {
            $queryBuilder->andWhere('export.createdAt <= :createdAtUntil');
            $queryBuilder->setParameter('createdAtUntil', $createdAtUntil);
        }

        $destinationId = $allExportsRequest->getDestinationId();
        if ($destinationId !== '') {
            $queryBuilder->join('export.destination', 'destination');
            $queryBuilder->andWhere('destination.id = :destinationId');
            $queryBuilder->setParameter('destinationId', $destinationId);
        }

        $createdById = $allExportsRequest->getCreatedById();
        if ($createdById !== '') {
            $queryBuilder->join('export.createdBy', 'createdBy');
            $queryBuilder->andWhere('createdBy.id = :createdById');
            $queryBuilder->setParameter('createdById', $createdById);
        }

        $query = $queryBuilder->getQuery();
        $result = $query->getResult();

        return $result;
    }
}
