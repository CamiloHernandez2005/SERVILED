<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DetailPurchase
 *
 * @property $id
 * @property $note
 * @property $description
 * @property $price_unit
 * @property $product_tax
 * @property $quantity_units
 * @property $date_purchase
 * @property $form_of_payment
 * @property $gross_total
 * @property $total_tax
 * @property $net_total
 * @property $total_value
 * @property $discount_total
 * @property $method_of_payment
 * @property $purchase_suppliers_id
 * @property $products_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Product $product
 * @property PurchaseSupplier $purchaseSupplier
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class DetailPurchase extends Model
{
    
    static $rules = [
		'note' => 'string',
		'description' => 'string',
		'price_unit' => 'required',
		'product_tax' => 'required',
		'quantity_units' => 'required',
		'date_purchase' => 'required',
		'form_of_payment' => 'required|string',
		'gross_total' => 'required',
		'total_tax' => 'required',
		'net_total' => 'required',
		'total_value' => 'required',
		'discount_total' => 'required',
		'method_of_payment' => 'required|string',
		'purchase_suppliers_id' => 'required',
		'products_id' => 'required',
    ];
    protected $table = 'detail_purchase';
    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['note','description','price_unit','product_tax','quantity_units','date_purchase','form_of_payment','gross_total','total_tax','net_total','total_value','discount_total','method_of_payment','purchase_suppliers_id','products_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'products_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchaseSupplier()
    {
        return $this->belongsTo(\App\Models\PurchaseSupplier::class, 'purchase_suppliers_id', 'id');
    }
    
    
}
