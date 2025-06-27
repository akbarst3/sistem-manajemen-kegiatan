<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Kegiatan extends Model
{
    use HasUuids;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'kegiatan';

    protected $fillable = [
        'judul',
        'deskripsi',
        'kuota',
        'status',
        'created_by',
    ];

    /*protected static function booted()*/
    /*{*/
    /*    static::creating(function ($daftarKegiatan) {*/
    /*        if (empty($program->id)) {*/
    /**/
    /*            $daftarKegiatan > id = (string) Str::uuid();*/
    /*        }*/
    /*    });*/
    /*}*/
    public function pembuat()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function peserta()
    {
        return $this->belongsToMany(User::class, 'kegiatan_user', 'kegiatan_id', 'user_id');
    }
}
