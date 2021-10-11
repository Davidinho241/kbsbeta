<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'external_key', 'name', 'email', 'phone', 'address', 'city', 'country', 'postal_code', 'currency', 'tenant_id', 'created_by', 'updated_by'
    ];

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

    public function tenant()
    {
        return $this->belongsTo('\App\Models\Tenant', 'tenant_id', 'id');
    }

    public function invoices()
    {
        return $this->hasMany('\App\Models\Invoice', 'customer_id', 'id');
    }

    public function subscriptions()
    {
        return $this->hasMany('\App\Models\Subscription', 'customer_id', 'id');
    }
}
