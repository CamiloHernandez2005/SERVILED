<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
   
    use HasFactory;
       protected $guarded = ['id'];

    protected $table = 'product_sale'; // Especifica el nombre de la tabla en la base de datos

    public function venta()
    {
        return $this->belongsTo(Sale::class, 'sale_id'); // Ajusta si es necesario el nombre de la clave foránea
    }

    public function producto()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
}
