<?php
namespace App\Models\Siswa;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Kelas\Kelas;
use App\Models\Jurusan\Jurusan;

class Siswa extends Model
{
    use SoftDeletes;

    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    public $timestamps = true; // otomatis create_at & update_at

    // Kolom yang bisa diisi
    protected $fillable = [
        'nis',
        'nama',
        'id_kelas',
        'id_jurusan',
        'tanggal_lahir'
    ];

    //kolom tanggal (supaya deleted_at dikenali laravel)
    protected $dates = ['created_at', 'update_at','deleted_at','tanggal_lahir'];

    // Relasi ke kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    // Relasi ke Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }

    //Mapping ke GraphQl (biar konsisten dengan schema)
    public function getIdSiswaAttribute()
    {
        return $this->attributes['id_siswa'];
    }

    public function getNamaAttribute()
    {
        return $this->attributes['nama'];
    }
}