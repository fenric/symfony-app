<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\UndecodableJsonException;
use App\Exception\UnhydrableObjectException;
use JsonException;
use Sunrise\Hydrator\Exception\InvalidValueException;
use Sunrise\Hydrator\Hydrator;

use function json_decode;
use function sprintf;

use const JSON_THROW_ON_ERROR;

final class SerializationService
{

    /**
     * Decodes the given JSON
     *
     * @param string $json
     * @param int $options
     *
     * @return array
     *
     * @throws UndecodableJsonException
     *         If the JSON cannot be decoded.
     */
    public function decodeJson(string $json, int $options = 0) : array
    {
        $options |= JSON_THROW_ON_ERROR;

        try {
            $data = (array) json_decode($json, true, 512, $options);
        } catch (JsonException $e) {
            throw new UndecodableJsonException(sprintf('Unable to decode JSON: %s', $e->getMessage()), 0, $e);
        }

        return $data;
    }

    /**
     * Hydrates the given object with the given data
     *
     * @template T as object
     *
     * @param T|class-string<T> $object
     * @param array $data
     *
     * @return T
     *
     * @throws UnhydrableObjectException
     *         If the data cannot be mapped to the object.
     */
    public function hydrateObject($object, array $data) : object
    {
        try {
            $object = (new Hydrator)->hydrate($object, $data);
        } catch (InvalidValueException $e) {
            throw new UnhydrableObjectException(sprintf('Unable to hydrate object: %s', $e->getMessage()), 0, $e);
        }

        /**
         * @var T $object
         */

        return $object;
    }
}
