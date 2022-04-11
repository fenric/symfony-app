<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\UndecodableJsonException;
use App\Exception\UndecodablePayloadException;
use App\Service\SerializationService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

use function array_walk_recursive;
use function is_string;
use function trim;

final class RequestListener
{

    /**
     * @var SerializationService
     */
    private SerializationService $serializationService;

    /**
     * Constructor of the class
     *
     * @param SerializationService $serializationService
     */
    public function __construct(SerializationService $serializationService)
    {
        $this->serializationService = $serializationService;
    }

    /**
     * @param RequestEvent $event
     *
     * @return void
     *
     * @throws UndecodablePayloadException
     *         If the request payload cannot be decoded.
     */
    public function onKernelRequest(RequestEvent $event) : void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        $this->parseRequestPayload($request);
        $this->stripWhitespacesFromRequestParsedBodyParams($request);
    }

    /**
     * @param Request $request
     *
     * @return void
     *
     * @throws UndecodablePayloadException
     *         If the request payload cannot be decoded.
     */
    private function parseRequestPayload(Request $request) : void
    {
        /** @var string */
        $content = $request->getContent(false);

        if ('' === $content) {
            return;
        }

        if ('json' === $request->getContentType()) {
            try {
                $data = $this->serializationService->decodeJson($content);
            } catch (UndecodableJsonException $e) {
                throw new UndecodablePayloadException($e->getMessage(), 0, $e);
            }

            $request->request->replace($data);
        }
    }

    /**
     * @param Request $request
     *
     * @return void
     */
    private function stripWhitespacesFromRequestParsedBodyParams(Request $request) : void
    {
        $data = $request->request->all();

        /**
         * @param mixed $value
         */
        array_walk_recursive($data, function (&$value) : void {
            $value = is_string($value) ? trim($value) : $value;
        });

        /**
         * @var array<array-key, mixed> $data
         */

        $request->request->replace($data);
    }
}
