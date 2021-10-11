<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'configuration', 'is_enable', 'tenant_id', 'gateway_id'
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

    public function gateway()
    {
        return $this->belongsTo('\App\Models\Gateway', 'gateway_id', 'id');
    }
}
