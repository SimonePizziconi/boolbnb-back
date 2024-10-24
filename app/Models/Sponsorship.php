<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    use HasFactory;

    public function apartments(){
        return $this->belongsToMany(Apartment::class);
    }
    
    protected $fillable = ['name', 'slug', 'price', 'duration'];
}
