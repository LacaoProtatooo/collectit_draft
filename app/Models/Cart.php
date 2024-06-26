<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
   use SoftDeletes;

   public function collectibles()
   {
        return $this->belongsToMany(Collectible::class)->withPivot('quantity');
   }
}
