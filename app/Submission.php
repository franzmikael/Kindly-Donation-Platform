<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $table = 't_submissions';

    protected $primaryKey = 'submisi_id';

    protected $fillable = [
        'submisi_judul','submisi_penerima', 'submisi_cerita', 'submisi_phone','submisi_tipe','submisi_hub_relasi', 'submisi_target', 'submisi_is_active','submisi_foto', 'submisi_expired_at'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
