<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class company extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'area_company');
    }
}
