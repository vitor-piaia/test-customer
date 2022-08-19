<?php

namespace Tests\Feature;

use App\Services\CompanyService;
use App\Services\CustomerService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testStoreSuccess()
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

        $data = [
            'name' => 'Cliente',
            'email' => 'cliente@teste.com',
            'phone' => '(11) 99706-7777',
            'birth' => '07/08/1990',
            'born' => 'Jundiaí',
            'companies' => [$company['company']->id]
        ];
        $response = app()->make(CustomerService::class)->store($data);
        $this->assertTrue($response['status']);
    }

    /**
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testStoreError()
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

        $data = [
            'name' => 'Cliente',
            'email' => 'cliente@teste.com',
            'phone' => '(11) 99706-7777',
            'birth' => '07/08/1990',
            'companies' => [$company['company']->id]
        ];
        $response = app()->make(CustomerService::class)->store($data);
        $this->assertTrue($response['status']);
    }

    /**
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testUpdateSuccess()
    {
        $companyService = app()->make(CompanyService::class);
        $customerService = app()->make(CustomerService::class);
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

        $data = [
            'name' => 'Cliente',
            'email' => 'cliente@teste.com',
            'phone' => '(11) 99706-7777',
            'birth' => '07/08/1990',
            'born' => 'Jundiaí',
            'companies' => [$company['company']->id]
        ];
        $customer = $customerService->store($data);
        unset($data['email']);
        $data['phone'] = '(11) 99706-7728';
        $response = $customerService->update($customer['customer']->id, $data);
        $this->assertTrue($response['status']);
    }

    /**
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testUpdateError()
    {
        $companyService = app()->make(CompanyService::class);
        $customerService = app()->make(CustomerService::class);
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

        $data = [
            'name' => 'Cliente',
            'email' => 'cliente@teste.com',
            'phone' => '(11) 99706-7777',
            'birth' => '07/08/1990',
            'born' => 'Jundiaí',
            'companies' => [$company['company']->id]
        ];
        $customer = $customerService->store($data);
        unset($data['email']);
        $data['phone'] = '(11) 99706-7728';
        $response = $customerService->update($customer['customer']->id+1, $data);
        $this->assertFalse($response['status']);
    }


    /**
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testDeleteSuccess()
    {
        $companyService = app()->make(CompanyService::class);
        $customerService = app()->make(CustomerService::class);
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

        $data = [
            'name' => 'Cliente',
            'email' => 'cliente@teste.com',
            'phone' => '(11) 99706-7777',
            'birth' => '07/08/1990',
            'born' => 'Jundiaí',
            'companies' => [$company['company']->id]
        ];
        $customer = $customerService->store($data);
        $response = $customerService->delete($customer['customer']->id);
        $this->assertTrue($response['status']);
    }


    /**
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testDeleteError()
    {
        $companyService = app()->make(CompanyService::class);
        $customerService = app()->make(CustomerService::class);
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

        $data = [
            'name' => 'Cliente',
            'email' => 'cliente@teste.com',
            'phone' => '(11) 99706-7777',
            'birth' => '07/08/1990',
            'born' => 'Jundiaí',
            'companies' => [$company['company']->id]
        ];
        $customer = $customerService->store($data);
        $response = $customerService->delete($customer['customer']->id+1);
        $this->assertFalse($response['status']);
    }
}
