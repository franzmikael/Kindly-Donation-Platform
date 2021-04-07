<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $table = 't_withdraw';

    protected $primaryKey = 'withdraw_id';

    protected $fillable = [
        'withdraw_id','submisi_id','user_id','withdraw_nominal','withdraw_bank_number','withdraw_is_approved','created_at','updated_at'
    ];
    
    public function submission() {
        return $this->hasOne(Submission::class, 'submisi_id', 'submisi_id');
    }
    
    public function user() {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }
}