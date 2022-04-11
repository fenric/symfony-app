<?php

declare(strict_types=1);

namespace App\Dto\Request;

final class UpdateExportRequest
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
}
