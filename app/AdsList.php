<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsList extends Model
{
    use HasFactory;

    protected $casts = [
        'other_features' => 'array',
        'building_features' => 'array',
        'images' => 'array',
    ];

    public function propertyType(){
        return $this->belongsTo(PropertyType::class, 'property_type');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
