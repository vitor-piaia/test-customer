<?php

namespace Tests\Feature;

use App\Services\CompanyService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testStoreSuccess()
    {
        $data = [
            'name' => 'Company',
            'cnpj' => '15.333.680/0001-33',
            'street' => 'Rua 123',
            'number' => '73',
            'postcode' => '13.202-255',
            'neighborhood' => 'Vila',
            'city' => 'Jundiai',
            'state' => 'São Paulo'
        ];
        $response = app()->make(CompanyService::class)->store($data);
        $this->assertTrue($response['status']);
    }

    /**
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testStoreError()
    {
        $data = [
            'name' => 'Company',
            'cnpj' => '15.333.680/0001-33',
            'street' => 'Rua 123',
            'number' => '73',
            'postcode' => '13.202-255',
            'neighborhood' => 'Vila',
            'city' => 'Jundiai'
        ];
        $response = app()->make(CompanyService::class)->store($data);
        $this->assertFalse($response['status']);
    }

    /**
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testUpdateSuccess()
    {
        $companyService = app()->make(CompanyService::class);
        $data = [
            'name' => 'Company',
            'cnpj' => '15.333.680/0001-33',
            'street' => 'Rua 123',
            'number' => '73',
            'postcode' => '13.202-255',
            'neighborhood' => 'Vila',
            'city' => 'Jundiai',
            'state' => 'São Paulo'
        ];
        $company = $companyService->store($data);
        unset($data['cnpj']);
        $data['street'] = 'Rua 12345';
        $data['postcode'] = '13.202-260';
        $response = $companyService->update($company['company']->id, $data);
        $this->assertTrue($response['status']);
    }

    /**
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testUpdateError()
    {
        $companyService = app()->make(CompanyService::class);
        $data = [
            'name' => 'Company',
            'cnpj' => '15.333.680/0001-33',
            'street' => 'Rua 123',
            'number' => '73',
            'postcode' => '13.202-255',
            'neighborhood' => 'Vila',
            'city' => 'Jundiai',
            'state' => 'São Paulo'
        ];
        $company = $companyService->store($data);
        unset($data['cnpj']);
        $response = $companyService->update($company['company']->id+1, $data);
        $this->assertFalse($response['status']);
    }


    /**
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testDeleteSuccess()
    {
        $companyService = app()->make(CompanyService::class);
        $data = [
            'name' => 'Company',
            'cnpj' => '15.333.680/0001-33',
            'street' => 'Rua 123',
            'number' => '73',
            'postcode' => '13.202-255',
            'neighborhood' => 'Vila',
            'city' => 'Jundiai',
            'state' => 'São Paulo'
        ];
        $company = $companyService->store($data);
        $response = $companyService->delete($company['company']->id);
        $this->assertTrue($response['status']);
    }


    /**
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testDeleteError()
    {
        $companyService = app()->make(CompanyService::class);
        $data = [
            'name' => 'Company',
            'cnpj' => '15.333.680/0001-33',
            'street' => 'Rua 123',
            'number' => '73',
            'postcode' => '13.202-255',
            'neighborhood' => 'Vila',
            'city' => 'Jundiai',
            'state' => 'São Paulo'
        ];
        $company = $companyService->store($data);
        $response = $companyService->delete($company['company']->id);
        $this->assertTrue($response['status']);
    }
}
