<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'duration', 'price', 'billing_period', 'type', 'product_id'
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

    public function product()
    {
        return $this->belongsTo('\App\Models\Product', 'product_id', 'id');
    }

    public function invoiceDetails()
    {
        return $this->hasMany('\App\Models\InvoiceDetail', 'plan_id', 'id');
    }

    public function subscriptions()
    {
        return $this->hasMany('\App\Models\Subscription', 'plan_id', 'id');
    }
}
