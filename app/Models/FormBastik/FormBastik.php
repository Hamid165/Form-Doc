<?php

namespace App\Models\FormBastik;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Support\Str;

#[Fillable([
    'petugas_id',
    'pimpinan_id',
    'nomor_surat',
    'tanggal_surat',
    'kota',
    'business_area',
    'status',
    'qr_token',
    'file_pdf_path',
    'file_docx_path',
    'rejection_note',
    'approved_by',
    'approved_at',
])]
class FormBastik extends Model
{
    protected $casts = [
        'approved_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->qr_token)) {
                $model->qr_token = Str::random(40);
            }
        });
    }

    public function petugas()
    {
        return $this->belongsTo(\App\Models\User::class, 'petugas_id');
    }

    public function pimpinan()
    {
        return $this->belongsTo(\App\Models\FormCctv\MasterSigner::class, 'pimpinan_id');
    }

    public function items()
    {
        return $this->hasMany(FormBastikItem::class, 'form_bastik_id')->orderBy('urutan_baris');
    }

    public function lampirans()
    {
        return $this->hasMany(FormBastikLampiran::class, 'form_bastik_id');
    }

    public function qrValidationLogs()
    {
        return $this->hasMany(QrValidationLog::class, 'form_bastik_id');
    }

    /**
     * Approval history audit trail.
     */
    public function approvalHistories()
    {
        return $this->hasMany(ApprovalHistory::class, 'form_bastik_id')->orderBy('created_at');
    }

    /**
     * The user who approved this document.
     */
    public function approver()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }

    /**
     * Check if document can be submitted for approval.
     */
    public function canBeSubmitted(): bool
    {
        return in_array($this->status, ['draft', 'rejected']);
    }

    /**
     * Check if document can be approved.
     */
    public function canBeApproved(): bool
    {
        return $this->status === 'submitted';
    }

    /**
     * Check if document can be rejected.
     */
    public function canBeRejected(): bool
    {
        return $this->status === 'submitted';
    }

    /**
     * Helper to get month in Roman numerals.
     */
    public static function getRomanMonth($monthNum): string
    {
        $romans = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $romans[(int)$monthNum] ?? '';
    }
}
