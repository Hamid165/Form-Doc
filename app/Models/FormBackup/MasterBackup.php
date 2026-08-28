<?php
namespace App\Models\FormBackup;
use Illuminate\Database\Eloquent\Model;

class MasterBackup extends Model
{
    protected $fillable = ['kategori', 'nama', 'jabatan', 'nipp'];
}