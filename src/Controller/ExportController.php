<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Request\AllExportsRequest;
use App\Service\DestinationService;
use App\Service\ExportService;
use App\Service\SerializationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ExportController extends AbstractController
{

    /**
     * @var SerializationService
     */
    private SerializationService $serializationService;

    /**
     * @var ExportService
     */
    private ExportService $exportService;

    /**
     * @var DestinationService
     */
    private DestinationService $destinationService;

    /**
     * Constructor of the class
     *
     * @param SerializationService $serializationService
     * @param ExportService $exportService
     * @param DestinationService $destinationService
     */
    public function __construct(
        SerializationService $serializationService,
        ExportService $exportService,
        DestinationService $destinationService
    ) {
        $this->serializationService = $serializationService;
        $this->exportService = $exportService;
        $this->destinationService = $destinationService;
    }

    /**
     * @Route(
     *   path="export",
     *   name="export_list",
     *   methods="GET"
     * )
     *
     * @param Request $request
     *
     * @return Response
     */
    public function exportListAction(Request $request) : Response
    {
        $allExportsRequest = $this->serializationService->hydrateObject(
            AllExportsRequest::class,
            $request->query->all()
        );

        $exports = $this->exportService->getAllExports($allExportsRequest);
        $exportDtos = [];
        foreach ($exports as $export) {
            $exportDtos[] = $this->exportService->convertExportToResponse($export);
        }

        $destinations = $this->destinationService->getAllDestinations();
        $destinationDtos = [];
        foreach ($destinations as $destination) {
            $destinationDtos[] = $this->destinationService->convertDestinationToResponse($destination);
        }

        return $this->render('export/list.html.twig', [
            'exports' => $exportDtos,
            'destinations' => $destinationDtos,
            'request' => $allExportsRequest,
        ]);
    }
}
