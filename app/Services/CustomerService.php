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
    public function all($filters)
    {
        if(!empty($filters)){
            $query = $this->model->select();
            foreach ($filters as $k => $v){
                if(in_array($k, $this->model->getFillable()))
                $query->where($k, 'LIKE', '%'.$v.'%');
            }
            return $query->get();
        }
        return $this->model->all();
    }

    /**
     * Store customer
     * @param array $post
     * @return array
     */
    public function store(array $post): array
    {
        DB::beginTransaction();
        try {
            $customer = $this->model->create([
                'name' => $post['name'],
                'email' => $post['email'],
                'phone' => $post['phone'],
                'birth' => $post['birth'],
                'born' => $post['born']
            ]);
            if (!$customer->id) {
                DB::rollback();
                return ['status' => false, 'message' => 'Ocorreu um erro.'];
            }
            $customer->companies()->sync($post['companies']);
            DB::commit();
            return ['status' => true, 'message' => 'Cliente criado com successo.', 'customer' => $customer];
        } catch (\Exception $e) {
            DB::rollback();
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Update customer
     * @param int $id
     * @param array $post
     * @return array
     */
    public function update(int $id, array $post): array
    {
        DB::beginTransaction();
        try {
            $query = $this->model->where('id', $id);
            if(!$query->exists())
                return ['status' => false, 'message' => 'Cliente inexistente.'];
            $update = $query->first()->update([
                'name' => $post['name'],
                'phone' => $post['phone'],
                'birth' => $post['birth'],
                'born' => $post['born']
            ]);
            if (!$update) {
                DB::rollback();
                return ['status' => false, 'message' => 'Ocorreu um erro.'];
            }
            $query->first()->companies()->sync($post['companies']);
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
            $customer = $this->model->find($id);
            if(empty($customer))
                return ['status' => false, 'message' => 'Cliente inexistente.'];
            $customer->companies()->detach();
            $delete = $customer->delete();
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
