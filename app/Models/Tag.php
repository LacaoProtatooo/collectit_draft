<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Tag extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name'
    ] ;

    public function collectibles()
    {
        return $this->belongsToMany(Collectible::class);
    }
}
