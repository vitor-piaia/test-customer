<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /** @var string $table */
    protected $table = 'companies';

    /** @var string $primaryKey */
    protected $primaryKey = 'id';

    /** @var array $fillable*/
    protected $fillable = [
        'id',
        'name',
        'cnpj',
        'street',
        'number',
        'postcode',
        'neighborhood',
        'city',
        'state'
    ];

    /** @var array $dates */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function customers()
    {
        return $this->belongsToMany(Customer::class,'customers_companies','company_id','customer_id');
    }

    /**
     * @return Attribute
     */
    protected function cnpj(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => substr($value, 0,2).'.'.substr($value, 2,3).'.'.substr($value, 5,3).'/'.substr($value, 8,-2).'-'.substr($value, -2),
            set: fn ($value) => str_replace(['/', '.', '-'], ['', '', ''], $value),
        );
    }

    /**
     * @return Attribute
     */
    protected function postcode(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => substr($value, 0,2).'.'.substr($value, 2,3).'-'.substr($value, -3),
            set: fn ($value) => str_replace(['.', '-'], ['', ''], $value),
        );
    }
}
