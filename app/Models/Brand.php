<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 *
 * @property $id
 * @property $abbrevation
 * @property $code
 * @property $name
 * @property $created_at
 * @property $updated_at
 *
 * @property Product[] $products
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Brand extends Model
{
    
    static $rules = [
		'code' => 'required',
		'name' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['abbrevation','code','name'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product', 'brands_id', 'id');
    }
    

}
