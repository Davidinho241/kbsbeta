<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceDetail extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment', 'quantity', 'invoice_id', 'plan_id'
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

    public function invoice()
    {
        return $this->belongsTo('\App\Models\Invoice', 'invoice_id', 'id');
    }

    public function plan()
    {
        return $this->belongsTo('\App\Models\Plan', 'plan_id', 'id');
    }
}
