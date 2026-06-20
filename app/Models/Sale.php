<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function cliente(){
        return $this->belongsTo(Person::class, 'clients_id');
    }

    public function productos(){
        return $this->belongsToMany(Product::class)->withTimestamps()
        ->withPivot('references','amount','selling_price','discounts','tax', 'iva');
    }

    public function detallesVentas()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    public function creditNoteSales()
{
    return $this->hasMany(credit_note_sales::class, 'sale_id');
}
}
