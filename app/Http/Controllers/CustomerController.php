<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerCollection;
use App\Services\CustomerService;
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

    public function list()
    {
        $customers = $this->customerService->all();
        if(count($customers) == 0)
            return response()->json(['message' => 'Não há dados cadastrados.'], Response::HTTP_OK);
        return CustomerCollection::collection($customers);
    }

    public function store(Request $request)
    {
        $response = $this->customerService->store($request->all());
        if($response['status'])
            return response()->json(['message' => $response['message']], Response::HTTP_INTERNAL_SERVER_ERROR);
        return response()->json(['message' => $response['message']], Response::HTTP_OK);
    }

    public function update($id, Request $request)
    {
        $response = $this->customerService->update($id, $request->all());
        if($response['status'])
            return response()->json(['message' => $response['message']], Response::HTTP_INTERNAL_SERVER_ERROR);
        return response()->json(['message' => $response['message']], Response::HTTP_OK);
    }

    public function delete($id)
    {
        $response = $this->customerService->delete($id);
        if($response['status'])
            return response()->json(['message' => $response['message']], Response::HTTP_INTERNAL_SERVER_ERROR);
        return response()->json(['message' => $response['message']], Response::HTTP_OK);
    }
}
