<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Conference;

class UserConference extends Model
{
    use HasFactory;

    protected $table = 'user_conferences';

    protected $fillable = [
        'conference_id',
        'user_id',
    ];

    public function conference() 
    {
        return $this->belongsTo(Conference::class, 'conference_id', 'id');
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
