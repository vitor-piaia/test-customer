<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCompany extends Model
{
    /** @var string $table */
    protected $table = 'customers_companies';

    /** @var string $primaryKey */
    protected $primaryKey = null;

    /** @var bool $incrementing */
    public $incrementing = false;

    /** @var array $fillable */
    protected $fillable = [
        'customer_id',
        'company_id'
    ];
}
