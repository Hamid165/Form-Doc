<?php

namespace App\Models\FormSerahTerimaUser;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormSerahTerimaUserItem extends Model
{
    protected $table = 'form_serah_terima_user_items';
    
    protected $guarded = ['id'];

    public function formSerahTerimaUser(): BelongsTo
    {
        return $this->belongsTo(FormSerahTerimaUser::class, 'form_serah_terima_user_id');
    }
}
