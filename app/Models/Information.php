<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;
    protected $fillable = [
        'identifier',
        'action',
        'challenge',
        'address',
        'phone',
        'food_type',
        'description',
        'website',
        'star_rating',
        'google_ratings',
        'type_id',

        'age_restricted',
        'business_name',
        'city',
        'state',
        'zip_code',
        'country',
        'start_date',
        'end_date',
        'geo_tag',
        'geo_link',
        'other_address_note',
        'length',
        'elevation_gain',
        'main_pic',
        'social_media',
        'main_video',
        'badge_award_one',
        'badge_award_two',
        'badge_award_three',
        'badge_award_four',
        'badge_award_five',
        'state_ranking_elevation',
        'state_ranking_prominence',
        'usa_ranking_elevation',
        'usa_ranking_prominence',
        'world_ranking_elevation',
        'facebook_link',
        'secondary_video',
        'instagram_link',
        'difficult_level',
        'picture_one',
        'picture_two',
        'picture_three',
        'tower_height',
        'focal_point',
    ];

    public function types()
    {
        return $this->belongsToMany(Type::class, 'information_types')->withTimestamps();
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'challenge_categories')->withTimestamps();
    }
    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class, 'challeng_subcategories')->withTimestamps();
    }

    public function subSubcategories()
    {
        return $this->belongsToMany(SubSubcategory::class, 'challenge_subsubcategories')->withTimestamps();
    }

    public function category(){
        return $this->hasMany(ChallengeCategory::class);
    }
}
