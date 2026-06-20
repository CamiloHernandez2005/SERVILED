<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Municipality
 *
 * @property $id
 * @property $code
 * @property $name
 * @property $created_at
 * @property $updated_at
 *
 * @property Municipality[] $municipalities
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */

class Municipality extends Model
{
    static $rules = [
		'code' => 'required',
		'name' => 'required',
    ];

    protected $perPage = 20;

    use HasFactory;

    protected $fillable = [ 'code','name','departments_id', 'municipality_id'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'departments_id');
    }

    public function person()
    {
        return $this->hasMany(Person::class, 'municipality_id');
    }



}
