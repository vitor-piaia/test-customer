<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyCollection;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    /** @var CompanyService $companyService */
    protected CompanyService $companyService;

    /**
     * CompanyController constructor.
     * @param CompanyService $companyService
     */
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    /**
     * List companies
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function list(): JsonResponse|AnonymousResourceCollection
    {
        $companies = $this->companyService->all();
        if(count($companies) == 0)
            return response()->json(['message' => 'Não há dados cadastrados'], Response::HTTP_OK);
        return CompanyCollection::collection($companies);
    }

    /**
     * Store company
     * @param CompanyRequest $request
     * @return JsonResponse
     */
    public function store(CompanyRequest $request): JsonResponse
    {
        echo'<pre>';print_r($request->all());exit('teste');
        $response = $this->companyService->create($request->all());
        if(!$response['status'])
            return response()->json(['message' => $response['message']], Response::HTTP_INTERNAL_SERVER_ERROR);
        return response()->json(['message' => $response['message']], Response::HTTP_OK);
    }

    /**
     * Update company
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        $response = $this->companyService->update($id, $request->all());
        if(!$response['status'])
            return response()->json(['message' => $response['message']], Response::HTTP_INTERNAL_SERVER_ERROR);
        return response()->json(['message' => $response['message']], Response::HTTP_OK);
    }

    /**
     * Delete company
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $response = $this->companyService->delete($id);
        if(!$response['status'])
            return response()->json(['message' => $response['message']], Response::HTTP_INTERNAL_SERVER_ERROR);
        return response()->json(['message' => $response['message']], Response::HTTP_OK);
    }
}
