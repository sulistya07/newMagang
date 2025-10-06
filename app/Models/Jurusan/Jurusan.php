<?php

namespace App\Models\Jurusan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Eloquent\SoftDeDeletes;

class Jurusan extends Model
{
    use SoftDeletes;

    protected $table = 'jurusan';
    protected $primaryKey = 'id_jurusan';
    public $timestamps = true; //otomatis create at & update_at
    // Kolom bisa diisi
    protected $fillabel = ['nama_jurusan'];
    // Kolom tanggal yang dipakai Laravel (biar delete_at dikenali)
    protected $dates = ['created_at', 'update_at', 'delete_at'];
    //Mapping ke schema GraphQL (id & nama)
    public function getIdAttribute()
    {
        return $this->id_jurusan;
    }
    public function getNamaAttribute()
    {
        return $this->nama_jurusan;
    }
}
