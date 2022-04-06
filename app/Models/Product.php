<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function mailings()
    {
        return $this->belongsToMany(Mailing::class);
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }
    public $incrementing = false;
}
