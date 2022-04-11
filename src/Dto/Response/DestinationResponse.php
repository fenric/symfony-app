<?php

declare(strict_types=1);

namespace App\Dto\Response;

use JsonSerializable;

final class DestinationResponse implements JsonSerializable
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
     * {@inheritdoc}
     */
    public function jsonSerialize() : array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
