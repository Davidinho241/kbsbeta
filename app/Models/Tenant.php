<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'api_secret', 'api_key', 'external_key', 'api_salt', 'created_by', 'updated_by'
    ];

    public function getFillable()
    {
        return $this->fillable;
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function customers()
    {
        return $this->hasMany('\App\Models\Customer', 'tenant_id', 'id');
    }

    public function services()
    {
        return $this->hasMany('\App\Models\Service', 'tenant_id', 'id');
    }

    public function paymentMethods()
    {
        return $this->hasMany('\App\Models\PaymentMethod', 'tenant_id', 'id');
    }

    public function invoices()
    {
        return $this->hasMany('\App\Models\Invoice', 'tenant_id', 'id');
    }
}
