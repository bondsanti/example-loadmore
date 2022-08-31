<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{  
    protected $table = 'tb_team';
    public function leader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
