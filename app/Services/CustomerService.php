<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    /** @var Customer $customer */
    protected Customer $model;

    /**
     * CustomerService constructor.
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }

    /**
     * List customers
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Store customer
     * @param array $data
     * @return array
     */
    public function store(array $data): array
    {
        DB::beginTransaction();
        try {
            $companies = $data['companies'];
            unset($data['companies']);
            $customer = $this->model->create($data);
            if (!$customer->id) {
                DB::rollback();
                return ['status' => false, 'message' => 'Ocorreu um erro.'];
            }
            $customer->companies()->sync($companies);
            DB::commit();
            return ['status' => true, 'message' => 'Cliente criado com successo.'];
        } catch (\Exception $e) {
            DB::rollback();
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Update customer
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update(int $id, array $data): array
    {
        DB::beginTransaction();
        try {
            $companies = $data['companies'];
            unset($data['companies']);
            $query = $this->model->where('id', $id);
            $update = $query->update($data);
            if (!$update) {
                DB::rollback();
                return ['status' => false, 'message' => 'Ocorreu um erro.'];
            }
            $query->first()->companies()->sync($companies);
            DB::commit();
            return ['status' => true, 'message' => 'Cliente atualizado com successo.'];
        } catch (\Exception $e) {
            DB::rollback();
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Delete customer
     * @param int $id
     * @return array
     */
    public function delete(int $id): array
    {
        DB::beginTransaction();
        try {
            $delete = $this->model->where('id', $id)->delete();
            if (!$delete) {
                DB::rollback();
                return ['status' => false, 'message' => 'Ocorreu um erro.'];
            }
            DB::commit();
            return ['status' => true, 'message' => 'Cliente excluido com successo.'];
        } catch (\Exception $e) {
            DB::rollback();
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
