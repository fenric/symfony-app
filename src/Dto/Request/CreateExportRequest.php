<?php

declare(strict_types=1);

namespace App\Dto\Request;

final class CreateExportRequest
{

    /**
     * @var string
     */
    private string $name = '';

    /**
     * @var string
     */
    private string $destinationId = '';

    /**
     * @var string
     */
    private string $createdById = '';

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
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
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name) : void
    {
        $this->name = $name;
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
