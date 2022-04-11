<?php

declare(strict_types=1);

namespace App\Dto\Request;

final class UpdateDestinationRequest
{

    /**
     * @var string
     */
    private string $name = '';

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
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
}
