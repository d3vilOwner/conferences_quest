<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Report;

class Conference extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'conference_date',
        'latitude',
        'longitude',
        'user_id',
        'country_id',
        'category_id',
        'subcategory_id',
    ];

    public function reports() {
        return $this->hasMany(Report::class);
    }

    public function country() 
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function listeners() {
        return $this->hasMany(UserConference::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category() 
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subcategory() 
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id', 'id');
    }
}
