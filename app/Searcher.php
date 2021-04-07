<?php

namespace App;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;

class Searcher extends Model implements Searchable
{
    protected $table = 't_submissions';
    
    protected $fillable = [
        'submisi_judul','submisi_penerima', 'submisi_cerita', 'submisi_phone','submisi_tipe','submisi_hub_relasi', 'submisi_target','submisi_foto', 'submisi_expired_at'
    ];
    
}
