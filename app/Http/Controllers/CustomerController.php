<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerCollection;
use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    /** @var CustomerService $customerService */
    protected CustomerService $customerService;

    /**
     * CustomerController constructor.
     * @param CustomerService $customerService
     */
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function list(Request $request)
    {
        $customers = $this->customerService->all($request->all());
        if(count($customers) == 0)
            return response()->json(['message' => 'Não há dados cadastrados.'], Response::HTTP_OK);
        return CustomerCollection::collection($customers);
    }

    /**
     * Store company
     * @param CustomerRequest $request
     * @return JsonResponse
     */
    public function store(CustomerRequest $request): JsonResponse
    {
        $response = $this->customerService->store($request->all());
        if($response['status'])
            return response()->json(['message' => $response['message']], Response::HTTP_INTERNAL_SERVER_ERROR);
        return response()->json(['message' => $response['message']], Response::HTTP_OK);
    }

    /**
     * Update customer
     * @param int $id
     * @param CustomerRequest $request
     * @return JsonResponse
     */
    public function update(int $id, CustomerRequest $request): JsonResponse
    {
        $response = $this->customerService->update($id, $request->all());
        if($response['status'])
            return response()->json(['message' => $response['message']], Response::HTTP_INTERNAL_SERVER_ERROR);
        return response()->json(['message' => $response['message']], Response::HTTP_OK);
    }

    /**
     * Delete customer
     * @param int $id
     * @param CustomerRequest $request
     * @return JsonResponse
     */
    public function delete(int $id, CustomerRequest $request): JsonResponse
    {
        $response = $this->customerService->delete($id);
        if($response['status'])
            return response()->json(['message' => $response['message']], Response::HTTP_INTERNAL_SERVER_ERROR);
        return response()->json(['message' => $response['message']], Response::HTTP_OK);
    }
}
