<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

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

    public function getPriceAttribute(){
        $jsonPrice = json_decode($this->attributes['price']);
        return $jsonPrice->XAF;
    }

    public function getDurationAttribute(){
        $jsonDuration = json_decode($this->attributes['duration'], true);
        if (Arr::has($jsonDuration, 'DAYS')){
            return $jsonDuration['DAYS'] .' DAYS';
        }else if (Arr::has($jsonDuration, 'MONTH')){
            return $jsonDuration['MONTH'] .' MONTH';
        }else if (Arr::has($jsonDuration, 'YEARS')){
            return $jsonDuration['YEARS'] .' YEARS';
        }
        return 'UNLIMITED';
    }

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
