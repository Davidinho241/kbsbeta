<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ref_invoice', 'external_ref_order', 'amount', 'customer_id', 'tenant_id'
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

    public function customer()
    {
        return $this->belongsTo('\App\Models\Customer', 'customer_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany('\App\Models\Transaction', 'invoice_id', 'id');
    }

    public function invoiceDetails()
    {
        return $this->hasMany('\App\Models\InvoiceDetail', 'invoice_id', 'id');
    }
}
