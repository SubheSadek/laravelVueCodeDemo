<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'information_id',
        'category_id',
    ];
    public function cat(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function subcategory(){
        return $this->hasMany(Subcategory::class, 'category_id', 'category_id');
    }
    public function subSubcategory(){
        return $this->hasMany(SubSubcategory::class, 'category_id', 'category_id');
    }
    public function challeng_cat(){
        return $this->hasMany(ChallengeCategory::class);
    }
    public function challeng_sub(){
        return $this->hasMany(ChallengSubcategory::class);
    }
    public function challeng_sub_sub(){
        return $this->hasMany(ChallengeSubsubcategory::class);
    }

}
