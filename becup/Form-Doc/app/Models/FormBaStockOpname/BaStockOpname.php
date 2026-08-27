<?php

namespace App\Models\FormBaStockOpname;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BaStockOpname extends Model
{
    protected $guarded = ['id'];

    public function details(): HasMany
    {
        return $this->hasMany(BaStockOpnameDetail::class);
    }
}
