<?php

declare(strict_types=1);

namespace App\Dto\Request;

use DateTimeImmutable;

final class AllExportsRequest
{

    /**
     * @var DateTimeImmutable|null
     */
    private ?DateTimeImmutable $createdAtFrom = null;

    /**
     * @var DateTimeImmutable|null
     */
    private ?DateTimeImmutable $createdAtUntil = null;

    /**
     * @var string
     */
    private string $destinationId = '';

    /**
     * @var string
     */
    private string $createdById = '';

    /**
     * @return DateTimeImmutable|null
     */
    public function getCreatedAtFrom() : ?DateTimeImmutable
    {
        return $this->createdAtFrom;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getCreatedAtUntil() : ?DateTimeImmutable
    {
        return $this->createdAtUntil;
    }

    /**
     * @return string
     */
    public function getDestinationId() : string
    {
        return $this->destinationId;
    }

    /**
     * @return string
     */
    public function getCreatedById() : string
    {
        return $this->createdById;
    }

    /**
     * @param DateTimeImmutable|null $createdAtFrom
     *
     * @return void
     */
    public function setCreatedAtFrom(?DateTimeImmutable $createdAtFrom) : void
    {
        $this->createdAtFrom = $createdAtFrom;
    }

    /**
     * @param DateTimeImmutable|null $createdAtUntil
     *
     * @return void
     */
    public function setCreatedAtUntil(?DateTimeImmutable $createdAtUntil) : void
    {
        $this->createdAtUntil = $createdAtUntil;
    }

    /**
     * @param string $destinationId
     *
     * @return void
     */
    public function setDestinationId(string $destinationId) : void
    {
        $this->destinationId = $destinationId;
    }

    /**
     * @param string $createdById
     *
     * @return void
     */
    public function setCreatedById(string $createdById) : void
    {
        $this->createdById = $createdById;
    }
}
