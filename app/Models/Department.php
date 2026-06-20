<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'countries_id'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'countries_id');
    }

    public function municipalities()
    {
        return $this->hasMany(Municipality::class, 'departments_id');
    }
}
