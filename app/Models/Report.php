<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Conference;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Subcategory;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';

    protected $fillable = [
        'topic',
        'report_start',
        'report_end',
        'description',
        'presentation',
        'conference_id',
        'user_id',
        'category_id',
        'subcategory_id',
        'is_online',
    ];

    public function conference() 
    {
        return $this->belongsTo(Conference::class, 'conference_id', 'id');
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function category() 
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subcategory() 
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id', 'id');
    }

    public function meetings() {
        return $this->hasMany(Meeting::class);
    }


}
