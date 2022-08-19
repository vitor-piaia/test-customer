<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    /** @var Company $company */
    protected Company $model;

    /**
     * CompanyService constructor.
     * @param Company $company
     */
    public function __construct(Company $company)
    {
        $this->model = $company;
    }

    /**
     * List companies
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Store company
     * @param array $post
     * @return array
     */
    public function store(array $post): array
    {
        DB::beginTransaction();
        try {
            $company = $this->model->create([
                'name' => $post['name'],
                'cnpj' => $post['cnpj'],
                'street' => $post['street'],
                'number' => $post['number'],
                'postcode' => $post['postcode'],
                'neighborhood' => $post['neighborhood'],
                'city' => $post['city'],
                'state' => $post['state']
            ]);
            if (!$company->id) {
                DB::rollback();
                return ['status' => false, 'message' => 'Ocorreu um erro.'];
            }
            DB::commit();
            return ['status' => true, 'message' => 'Empresa cadastrada com successo.', 'company' => $company];
        } catch (\Exception $e) {
            DB::rollback();
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Update company
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
                return ['status' => false, 'message' => 'Empresa inexistente.'];
            $update = $query->first()->update([
                'name' => $post['name'],
                'street' => $post['street'],
                'number' => $post['number'],
                'postcode' => $post['postcode'],
                'neighborhood' => $post['neighborhood'],
                'city' => $post['city'],
                'state' => $post['state']
            ]);
            if (!$update) {
                DB::rollback();
                return ['status' => false, 'message' => 'Ocorreu um erro.'];
            }
            DB::commit();
            return ['status' => true, 'message' => 'Empresa atualizada com successo.'];
        } catch (\Exception $e) {
            DB::rollback();
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Delete company
     * @param int $id
     * @return array
     */
    public function delete(int $id): array
    {
        DB::beginTransaction();
        try {
            $company = $this->model->find($id);
            if($company->customers()->count() > 0)
                return ['status' => false, 'message' => 'A empresa não pode ser excluída, ela está vincula a um ou mais clientes.'];

            $delete = $this->model->where('id', $id)->delete();
            if (!$delete) {
                DB::rollback();
                return ['status' => false, 'message' => 'Ocorreu um erro.'];
            }
            DB::commit();
            return ['status' => true, 'message' => 'Empresa excluida com successo.'];
        } catch (\Exception $e) {
            DB::rollback();
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
