<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'role',
        'action',
        'description',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Record an activity log entry.
     */
    public static function log(string $action, ?string $description = null)
    {
        try {
            $user = auth()->user();
            return self::create([
                'user_id' => $user->id ?? null,
                'user_name' => $user->name ?? 'Guest/Public',
                'role' => $user->role ?? 'guest',
                'action' => $action,
                'description' => $description,
                'ip_address' => request()->ip(),
            ]);
        } catch (\Exception $e) {
            // Ignore log recording failures
        }
    }
}
