<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengSubcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'information_id',
        'subcategory_id',
        'challenge_category_id',
    ];

    public function subcategory(){
        return $this->belongsTo(Subcategory::class);
    }
    public function sub_subcategories(){
        return $this->hasMany(ChallengeSubsubcategory::class, 'challenge_subcategory_id');
    }

    public function subSubcategory(){
        return $this->hasMany(SubSubcategory::class, 'subcategory_id', 'subcategory_id');
    }
}
