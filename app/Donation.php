<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $table = 't_donations';

    protected $fillable = [
        'donation_id','submisi_id','user_id','donation_name','donation_mail','donation_phone','donation_nominal','donation_is_anonymous','payment_type','created_at','updated_at'
    ];
    
    public function submission() {
        return $this->hasOne(Submission::class, 'submisi_id', 'submisi_id');
    }
}