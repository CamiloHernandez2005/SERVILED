<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PurchaseSupplier
 *
 * @property $id
 * @property $invoice_number_purchase
 * @property $date_invoice_purchase
 * @property $users_id
 * @property $people_id
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PurchaseSupplier extends Model
{
    
    static $rules = [
		'invoice_number_purchase' => 'required|string',
		'date_invoice_purchase' => 'required',
    'code'=>'required',
		'users_id' => 'required',
		'people_id' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['invoice_number_purchase','date_invoice_purchase','code','users_id','people_id'];

    public function person()
    {
        return $this->belongsTo('App\Models\Person', 'people_id');
    }
    public function detailPurchases()
{
    return $this->hasMany(DetailPurchase::class, 'purchase_suppliers_id', 'id');
}
public function user()
{
    return $this->belongsTo(User::class, 'users_id');
}





}
