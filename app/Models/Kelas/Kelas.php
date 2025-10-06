<?php

namespace App\Models\Kelas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Eloquent\SoftDeDeletes;

class Kelas extends Model
{
    use SoftDeletes;

    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';
    public $timestamps = true; //otomatis create at & update_at
    // Kolom bisa diisi
    protected $fillabel = ['nama_kelas'];
    // Kolom tanggal yang dipakai Laravel (biar delete_at dikenali)
    protected $dates = ['created_at', 'update_at', 'delete_at'];
    //Mapping ke schema GraphQL (id & nama)
    public function getIdAttribute()
    {
        return $this->id_kelas;
    }
    public function getNamaAttribute()
    {
        return $this->nama_kelas;
    }
}
