<?php

declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\Dto\Request\AllExportsRequest;
use App\Dto\Request\CreateExportRequest;
use App\Dto\Request\UpdateExportRequest;
use App\Service\SerializationService;
use App\Service\ExportService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ExportController
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
     * Constructor of the class
     *
     * @param SerializationService $serializationService
     * @param ExportService $exportService
     */
    public function __construct(
        SerializationService $serializationService,
        ExportService $exportService
    ) {
        $this->serializationService = $serializationService;
        $this->exportService = $exportService;
    }

    /**
     * @Route(
     *   path="/api/v1/export",
     *   name="api_v1_export_create",
     *   methods="POST"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createExportAction(Request $request) : JsonResponse
    {
        $createExportRequest = $this->serializationService->hydrateObject(
            CreateExportRequest::class,
            $request->request->all()
        );

        $export = $this->exportService->createExportFromRequest($createExportRequest);
        $exportDto = $this->exportService->convertExportToResponse($export);

        return new JsonResponse($exportDto);
    }

    /**
     * @Route(
     *   path="/api/v1/export/{export_id}",
     *   name="api_v1_export_read",
     *   methods="GET"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function readExportAction(Request $request) : JsonResponse
    {
        $export = $this->exportService->getExportById($request->attributes->get('export_id'));
        $exportDto = $this->exportService->convertExportToResponse($export);

        return new JsonResponse($exportDto);
    }

    /**
     * @Route(
     *   path="/api/v1/export/{export_id}",
     *   name="api_v1_export_update",
     *   methods="PATCH"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function updateExportAction(Request $request) : JsonResponse
    {
        $export = $this->exportService->getExportById($request->attributes->get('export_id'));

        $updateExportRequest = $this->serializationService->hydrateObject(
            UpdateExportRequest::class,
            $request->request->all()
        );

        $export = $this->exportService->updateExportFromRequest($export, $updateExportRequest);
        $exportDto = $this->exportService->convertExportToResponse($export);

        return new JsonResponse($exportDto);
    }

    /**
     * @Route(
     *   path="/api/v1/export/{export_id}",
     *   name="api_v1_export_delete",
     *   methods="DELETE"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function deleteExportAction(Request $request) : JsonResponse
    {
        $export = $this->exportService->getExportById($request->attributes->get('export_id'));
        $this->exportService->deleteExport($export);

        return new JsonResponse();
    }

    /**
     * @Route(
     *   path="/api/v1/export",
     *   name="api_v1_export_all",
     *   methods="GET"
     * )
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function allExportsAction(Request $request) : JsonResponse
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

        return new JsonResponse($exportDtos);
    }
}
