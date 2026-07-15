<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surat extends Model
{
    use SoftDeletes;

    protected $table = 'surat';

    protected $fillable = [
        'jenis_surat_id',
        'sifat_surat_id',
        'prioritas_surat_id',
        'template_surat_id',
        'pengirim_id',
        'nomor_surat',
        'perihal',
        'ringkasan',
        'isi_surat',
        'tanggal_surat',
        'tanggal_kirim',
        'tanggal_selesai',
        'status',
        'catatan',
        'file_surat',
        'is_archived',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_surat' => 'date',
            'tanggal_kirim' => 'datetime',
            'tanggal_selesai' => 'datetime',
            'is_archived' => 'boolean',
        ];
    }

    public function pengirim(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengirim_id');
    }

    public function jenisSurat(): BelongsTo
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function sifatSurat(): BelongsTo
    {
        return $this->belongsTo(SifatSurat::class);
    }

    public function prioritasSurat(): BelongsTo
    {
        return $this->belongsTo(PrioritasSurat::class);
    }

    public function templateSurat(): BelongsTo
    {
        return $this->belongsTo(TemplateSurat::class);
    }

    public function lampiran(): HasMany
    {
        return $this->hasMany(Lampiran::class);
    }

    public function approval(): HasMany
    {
        return $this->hasMany(Approval::class);
    }

    public function disposisi(): HasMany
    {
        return $this->hasMany(Disposisi::class);
    }

    public function tujuan(): HasMany
    {
        return $this->hasMany(SuratTujuan::class);
    }

    public function arsip(): HasOne
    {
        return $this->hasOne(Arsip::class);
    }
}