<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @property $id
 * @property $name_product
 * @property $description_long
 * @property $factory_reference
 * @property $classification_tax
 * @property $selling_price
 * @property $purchase_price
 * @property $photo
 * @property $status
 * @property $stock
 * @property $subcategory_product
 * @property $category_products_id
 * @property $brands_id
 * @property $measurement_units_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Brand $brand
 * @property CategoryProduct $categoryProduct
 * @property MeasurementUnit $measurementUnit
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Product extends Model
{
    
    static $rules = [
		'name_product' => 'required',
		// 'description_long' => 'required',
		'factory_reference' => 'required',
		'classification_tax' => 'required',
        'selling_price' => 'required',
        'subcategory_product' => 'required',
		'category_products_id' => 'required',
		'brands_id' => 'required',
		'measurement_units_id' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name_product','description_long','factory_reference','classification_tax','selling_price','photo','subcategory_product','category_products_id','brands_id','measurement_units_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function brand()
    {
        return $this->hasOne('App\Models\Brand', 'id', 'brands_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function categoryProduct()
    {
        return $this->hasOne('App\Models\CategoryProduct', 'id', 'category_products_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function measurementUnit()
    {
        return $this->hasOne('App\Models\MeasurementUnit', 'id', 'measurement_units_id');
    }

    public function detalleVenta()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    public function priceHistory()
    {
        return $this->hasMany(Sale::class, 'product_id');
    }

}
