<?php

namespace App\Models\FormBaStockOpname;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BaStockOpnameDetail extends Model
{
    protected $guarded = ['id'];

    public function baStockOpname(): BelongsTo
    {
        return $this->belongsTo(BaStockOpname::class);
    }
}
