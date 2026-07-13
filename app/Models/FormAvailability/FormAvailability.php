<?php

namespace App\Models\FormAvailability;

use App\Models\FormCctv\MasterSigner;
use Illuminate\Database\Eloquent\Model;

class FormAvailability extends Model
{
    protected $table = 'form_availability_ticketings';

    protected $fillable = [
        'no_ref',
        'tanggal',
        'business_area',
        'daop_divre',
        'jumlah_total_station',
        'jumlah_perangkat_ticketing',
        'catatan',
        'petugas_name',
        'petugas_nipp',
        'mengetahui_id',
        'mengetahui_nipp_mode',
        'mengetahui_nipp_override',
        'mengetahui_nama_override',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(
            FormAvailabilityItem::class,
            'form_availability_ticketing_id'
        );
    }

    public function mengetahui()
    {
        return $this->belongsTo(
            MasterSigner::class,
            'mengetahui_id'
        );
    }

    /**
     * Mode tanda tangan:
     * - master: mengikuti master signer
     * - custom: input manual
     * - hidden: identitas dikosongkan
     */
    public function getModePenandatanganAttribute(): string
    {
        return $this->mengetahui_nipp_mode
            ?? 'master';
    }

    /**
     * Memisahkan isi manual:
     *
     * Baris pertama:
     * JABATAN
     *
     * Baris kedua dan seterusnya:
     * NAMA PENANDATANGAN
     */
    private function identitasManualTerpisah(): array
    {
        $rawIdentity = trim(
            (string) $this->mengetahui_nama_override
        );

        if ($rawIdentity === '') {
            return [
                'jabatan' => null,
                'nama' => null,
            ];
        }

        $splitLines = preg_split(
            '/\R/u',
            $rawIdentity
        );

        $lines = array_values(
            array_filter(
                array_map(
                    static fn ($line) => trim(
                        (string) $line
                    ),
                    $splitLines ?: []
                ),
                static fn ($line) => $line !== ''
            )
        );

        if (empty($lines)) {
            return [
                'jabatan' => null,
                'nama' => null,
            ];
        }

        /*
         * Jika hanya satu baris,
         * dianggap sebagai nama tanpa jabatan.
         */
        if (count($lines) === 1) {
            return [
                'jabatan' => null,
                'nama' => $lines[0],
            ];
        }

        /*
         * Baris pertama menjadi jabatan.
         */
        $jabatan = array_shift($lines);

        /*
         * Sisa baris menjadi nama.
         */
        $nama = implode(
            "\n",
            $lines
        );

        return [
            'jabatan' => $jabatan,
            'nama' => $nama,
        ];
    }

    /**
     * Nama penandatangan yang akan dicetak.
     */
    public function getNamaPenandatanganAttribute(): ?string
    {
        return match ($this->mode_penandatangan) {
            'custom' =>
                $this->identitasManualTerpisah()['nama'],

            'hidden' => null,

            default =>
                $this->mengetahui?->nama,
        };
    }

    /**
     * Jabatan penandatangan yang akan dicetak.
     */
    public function getJabatanPenandatanganAttribute(): ?string
    {
        return match ($this->mode_penandatangan) {
            'custom' =>
                $this->identitasManualTerpisah()['jabatan'],

            'hidden' => null,

            default =>
                $this->mengetahui?->jabatan,
        };
    }

    /**
     * NIPP penandatangan yang akan dicetak.
     */
    public function getNippPenandatanganAttribute(): ?string
    {
        return match ($this->mode_penandatangan) {
            'custom' =>
                $this->mengetahui_nipp_override,

            'hidden' => null,

            default =>
                $this->mengetahui?->nipp,
        };
    }

    /**
     * Mengecek apakah seluruh identitas penandatangan
     * harus dikosongkan.
     */
    public function identitasPenandatanganKosong(): bool
    {
        return $this->mode_penandatangan
            === 'hidden';
    }

    /**
     * Mengecek apakah NIPP perlu ditampilkan.
     */
    public function tampilkanNippPenandatangan(): bool
    {
        return !$this->identitasPenandatanganKosong()
            && filled(
                $this->nipp_penandatangan
            );
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isDicetak(): bool
    {
        return $this->status === 'dicetak';
    }

    public function isSelesai(): bool
    {
        return $this->status === 'selesai';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'dicetak' => 'Dicetak',
            'selesai' => 'Selesai',
            default => 'Unknown',
        };
    }
}
