<?php

namespace App\Models\Ekstrakurikuler;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ekstrakurikuler extends Model
{
    use SoftDeletes;

    protected $table = 'ekstrakurikuler';
    protected $primaryKey = 'id_ekskul';
    public $timestamps = true; // otomatis created_at & updated_at
    // Kolom yang bisa diisi
    protected $fillable = [
        'nama_ekskul',
        'pembina',
        'jadwal',
        'kuota'
    ];
    // Kolom tanggal yang dipakai Laravel (biar deleted_at dikenali)
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    // Mapping ke schema GraphQL (id & nama)
    public function getIdAttribute()
    {
        return $this->id_ekskul;
    }
    public function getNamaAttribute()
    {
        return $this->nama_ekskul;
    }
}
