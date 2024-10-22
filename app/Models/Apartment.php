<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function statistics()
    {
        return $this->hasMany(Statistic::class);
    }

    public function sponsorships()
    {
        return $this->belongsToMany(Sponsorship::class)->withPivot('start_date', 'end_date');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'rooms',
        'beds',
        'bathrooms',
        'square_meters',
        'address',
        'city',
        'cap',
        'latitude',
        'longitude',
        'image_path',
        'image_original_name',
        'is_visible',
        'created_at',
        'updated_at',
    ];
}
