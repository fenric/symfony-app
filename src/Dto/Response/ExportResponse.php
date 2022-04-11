<?php

declare(strict_types=1);

namespace App\Dto\Response;

use DateTimeImmutable;
use DateTimeInterface;
use JsonSerializable;

final class ExportResponse implements JsonSerializable
{

    /**
     * @var string
     */
    private string $id = '';

    /**
     * @var string
     */
    private string $name = '';

    /**
     * @var DateTimeImmutable|null
     */
    private ?DateTimeImmutable $createdAt = null;

    /**
     * @var DestinationResponse|null
     */
    private ?DestinationResponse $destination = null;

    /**
     * @var UserResponse|null
     */
    private ?UserResponse $createdBy = null;

    /**
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getCreatedAt() : ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return DestinationResponse|null
     */
    public function getDestination() : ?DestinationResponse
    {
        return $this->destination;
    }

    /**
     * @return UserResponse|null
     */
    public function getCreatedBy() : ?UserResponse
    {
        return $this->createdBy;
    }

    /**
     * @param string $id
     *
     * @return void
     */
    public function setId(string $id) : void
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    /**
     * @param DateTimeImmutable|null $createdAt
     *
     * @return void
     */
    public function setCreatedAt(?DateTimeImmutable $createdAt) : void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param DestinationResponse|null $destination
     *
     * @return void
     */
    public function setDestination(?DestinationResponse $destination) : void
    {
        $this->destination = $destination;
    }

    /**
     * @param UserResponse|null $createdBy
     *
     * @return void
     */
    public function setCreatedBy(?UserResponse $createdBy) : void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        $createdAt = $this->createdAt;
        if (isset($createdAt)) {
            $createdAt = $createdAt->format(DateTimeInterface::W3C);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'createdAt' => $createdAt,
            'destination' => $this->destination,
            'createdBy' => $this->createdBy,
        ];
    }
}
