<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collectible extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'dimension',
        'condition',
        'stock',
        'manufacturer',
        'category',
        'image_path'
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function events()
    {
        return $this->has(Event::class);
    }
}
