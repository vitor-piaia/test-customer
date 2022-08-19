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
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        DB::beginTransaction();
        try {
            $company = $this->model->create($data);
            if (!$company->id) {
                DB::rollback();
                return ['status' => false, 'message' => 'Ocorreu um erro.'];
            }
            DB::commit();
            return ['status' => true, 'message' => 'Empresa cadastrada com successo.'];
        } catch (\Exception $e) {
            DB::rollback();
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Update company
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update(int $id, array $data): array
    {
        DB::beginTransaction();
        try {
            $update = $this->model->where('id', $id)->update($data);
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
     * @param $id
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
            return ['status' => true, 'message' => 'Empresa excluida com successo.'];
        } catch (\Exception $e) {
            DB::rollback();
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
