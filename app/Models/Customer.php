<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /** @var string $table */
    protected $table = 'customers';

    /** @var string $primaryKey */
    protected $primaryKey = 'id';

    /** @var array $fillable*/
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'birth',
        'born'
    ];

    /** @var array $dates */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function companies()
    {
        return $this->belongsToMany(Company::class,'customers_companies','customer_id','company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function phone(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => '(' . substr($value, 0, 2).') '.substr($value, 2, -4).'-'.substr($value, -4),
            set: fn ($value) => str_replace(['(', ')', ' '], ['', '', ''], $value),
        );
    }
}
