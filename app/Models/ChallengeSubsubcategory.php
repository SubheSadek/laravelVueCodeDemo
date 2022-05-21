<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeSubsubcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'information_id',
        'challenge_category_id',
        'challenge_subcategory_id',
        'sub_subcategory_id',
    ];

    public function sub_subcategory(){
        return $this->belongsTo(SubSubcategory::class)->select('id', 'sub_subcat_name');
    }
}
