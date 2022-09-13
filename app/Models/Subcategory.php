<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
    ];

    public function category() 
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function conferences() 
    {
        return $this->hasMany(Conference::class);
    }

    public function reports() 
    {
        return $this->hasMany(Report::class);
    }
}
