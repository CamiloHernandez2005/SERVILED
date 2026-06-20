<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoryProduct
 *
 * @property $id
 * @property $name
 * @property $description
 * @property $created_at
 * @property $updated_at
 *
 * @property Product[] $products
 * @property SubCategory[] $subCategories
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class CategoryProduct extends Model
{
    
    static $rules = [
		'name' => 'required|string',
		'description' => 'required|string',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','description'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product', 'category_products_id','id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subCategories()
    {
        return $this->hasMany(\App\Models\SubCategory::class, 'category_id', 'id' )->where('status', true);
    }
    

}
