<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subcategory;
use App\Models\Conference;
use App\Models\Report;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function subcategories() {
        return $this->hasMany(Subcategory::class);
    }

    public function conferences() {
        return $this->hasMany(Conference::class);
    }

    public function reports() {
        return $this->hasMany(Report::class);
    }
}
