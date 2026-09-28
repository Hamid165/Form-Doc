<?php

namespace App\Models\FormSerahTerimaUser;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormSerahTerimaUser extends Model
{
    protected $table = 'form_serah_terima_users';
    
    protected $guarded = ['id'];

    public function items(): HasMany
    {
        return $this->hasMany(FormSerahTerimaUserItem::class, 'form_serah_terima_user_id');
    }
}
