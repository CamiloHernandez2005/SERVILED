<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SubCategory
 *
 * @property $id
 * @property $name
 * @property $description
 * @property $category_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Product[] $products
 * @property CategoryProduct $categoryProduct
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class SubCategory extends Model
{
    
    static $rules = [
		'name' => 'required|string',
		// 'description' => 'required|string',
		// 'category_id' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','description','category_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoryProduct()
    {
        return $this->belongsTo(\App\Models\CategoryProduct::class, 'category_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(\App\Models\Product::class, 'id', 'subcategory_product_id');
    }
    

}
