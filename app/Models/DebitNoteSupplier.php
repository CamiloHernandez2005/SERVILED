<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DebitNoteSupplier
 *
 * @property $id
 * @property $debit_note_code
 * @property $date_invoice
 * @property $detail_purchase_id
 * @property $users_id
 * @property $purchase_suppliers_id
 * @property $quantity
 * @property $description
 * @property $total
 * @property $net_total
 * @property $gross_total
 * @property $created_at
 * @property $updated_at
 *
 * @property DetailPurchase $detailPurchase
 * @property PurchaseSupplier $purchaseSupplier
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class DebitNoteSupplier extends Model
{
    
    static $rules = [
		'debit_note_code' => 'required|string',
		'date_invoice' => 'required',
		'detail_purchase_id' => 'required',
		'users_id' => 'required',
		'purchase_suppliers_id' => 'required',
		'quantity' => 'required',
		'description' => 'required|string',
		'total' => 'required',
		'net_total' => 'required',
		'gross_total' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['debit_note_code','date_invoice','detail_purchase_id','users_id','purchase_suppliers_id','quantity','description','total','net_total','gross_total'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function detailPurchase()
    {
        return $this->belongsTo(\App\Models\DetailPurchase::class, 'detail_purchase_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchaseSupplier()
    {
        return $this->belongsTo(\App\Models\PurchaseSupplier::class, 'purchase_suppliers_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'users_id', 'id');
    }
    

}
