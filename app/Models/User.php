<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email',
    ];

    public function teams()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function sub_team()
    {
        return $this->belongsTo(User::class, 'sub_team_id');
        // return $this->hasOne(sub_team::class);
    }
    public function leader($user)
    {
        $subteam = sub_team::find($user->sub_team_id);
        if ($subteam == null) return false;
        $subteam->user_id = sub_team::find($user->sub_team_id);
        $user = User::find($subteam->user_id);
        return ($user) ? $user : '';
    }

}
