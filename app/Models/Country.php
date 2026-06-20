<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    
    public function department()
    {
        return $this->hasMany(Department::class, 'countries_id');
    }
}
