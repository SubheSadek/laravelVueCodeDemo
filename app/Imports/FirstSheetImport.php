<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\ChallengeCategory;
use App\Models\ChallengSubcategory;
use App\Models\Information;
use App\Models\Subcategory;
use App\Models\SubSubcategory;
use App\Models\Type;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Validators\Failure;

class FirstSheetImport implements ToCollection, WithHeadingRow, SkipsOnError

{

    use Importable, SkipsErrors, SkipsFailures;

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {

            if($row['type'] || $row['age_restricted']){

            //     $checkInfo = Information::where('identifier', trim($row['identifier']))->count();

                // \Log::info("we get", ["d" => trim($row['identifier'])]);




                    $info = Information::create([
                        // 'identifier' => trim($row['identifier']),
                        'age_restricted' => $row['age_restricted'],
                        'action' => $row['action'],
                        'challenge' => $row['challenge_name'],
                        'address' => $row['address'],
                        'phone' => $row['phone_number'],
                        'food_type' => $row['type_of_food'],
                        'description' => $row['description'],
                        'website' => $row['website'],
                        'star_rating' => $row['star_rating'],
                        'google_ratings' => $row['google_rating'],
                        'business_name' => $row['business_name'],
                        'city' => $row['city'],
                        'state' => $row['state'],
                        'zip_code' => $row['zip_code'],
                        'country' => $row['country'],
                        'event_date' => $row['event_dates'],
                        'geo_tag' => $row['geo_tag'],
                        'geo_link' => $row['geo_link'],
                        'length' => $row['length'],
                        'elevation_gain' => $row['elevation_gain'],
                        'main_pic' => $row['main_picture'],
                        'social_media' => $row['social_media'],
                        'main_video' => $row['main_video'],
                        'badge_award_one' => $row['badge_awarded_1'],
                        'badge_award_two' => $row['badge_awarded_2'],
                        'badge_award_three' => $row['badge_awarded_3'],
                        'badge_award_four' => $row['badge_awarded_4'],
                        'badge_award_five' => $row['badge_awarded_5'],
                        'state_ranking_elevation' => $row['state_ranking_elevation'],
                        'state_ranking_prominence' => $row['state_ranking_prominence'],
                        'usa_ranking_elevation' => $row['usa_ranking_elevation'],
                        'usa_ranking_prominence' => $row['usa_ranking_prominence'],
                        'world_ranking_elevation' => $row['world_ranking_elevation'],
                        'facebook_link' => $row['facebook_link'],
                        'secondary_video' => $row['secondary_video'],
                        'instagram_link' => $row['instagram_link'],
                        'difficult_level' => $row['difficult_level'],
                        'picture_two' => $row['picture_2'],
                        'picture_three' => $row['picture_3'],
                        'tower_height' => $row['tower_height'],
                        'focal_point' => $row['focal_point']
                    ]);

                    $type = $row['type'];
                    if($type){

                        $type=trim($type);

                        $type_parts = explode(",", $type);

                        foreach($type_parts as $tp){
                            $tp = trim($tp);
                            $types = Type::firstOrCreate(
                                ['type_name' =>  $tp]
                            );
                            $typeId = $types->id;

                            $info->types()->attach($typeId);
                        }
                    }

                    $parentCat1 = [
                        'parent' =>$row['parent_1'],
                        'sub' =>[
                            [
                                'subcategory'=>$row['sub1_1'],
                                'sub_subcategory'=>$row['sub1_1_1'],
                            ],
                            [
                                'subcategory'=>$row['sub1_2'],
                                'sub_subcategory'=>$row['sub1_2_1'],
                            ],
                        ],

                    ];
                    $parentCat2 = [
                        'parent' =>$row['parent_2'],
                        'sub' =>[
                            [
                                'subcategory'=>$row['sub2_1'],
                                'sub_subcategory'=>$row['sub2_1_1'],
                            ],
                            [
                                'subcategory'=>$row['sub2_2'],
                                'sub_subcategory'=>$row['sub2_2_1'],
                            ],
                        ],

                    ];

                    $parentCat3 = [
                        'parent' =>$row['parent_3'],
                        'sub' => [
                            [
                                'subcategory'=>$row['sub3_1'],
                                'sub_subcategory'=>$row['sub3_1_1'],
                            ],
                            [
                                'subcategory'=>$row['sub3_2'],
                                'sub_subcategory'=>$row['sub3_2_1'],
                            ],
                        ],

                    ];
                    $parentCat4 = [
                        'parent' =>$row['parent_4'],
                        'sub' =>[
                            [
                                'subcategory'=>$row['sub4_1'],
                                'sub_subcategory'=>$row['sub4_1_1'],
                            ],
                            [
                                'subcategory'=>$row['sub4_2'],
                                'sub_subcategory'=>$row['sub4_2_1'],
                            ],
                        ],

                    ];
                    $parentCat5 = [
                        'parent' =>$row['parent_5'],
                        'sub'=> [
                            [
                                'subcategory'=>$row['sub5_1'],
                                'sub_subcategory'=>$row['sub4_1_1'],
                            ],
                            [
                                'subcategory'=>$row['sub5_2'],
                                'sub_subcategory'=>$row['sub5_2_1'],
                            ],
                        ],
                    ];

                    $arr = [$parentCat1, $parentCat2, $parentCat3, $parentCat4, $parentCat5];

                    foreach ($arr as $item){

                        if($item['parent']){

                            $cat = Category::firstOrCreate(
                                ['cat_name' =>  $item['parent']],
                                ['cat_name' =>  $item['parent']]
                            );
                            $catId = $cat->id;
                            $ob1 =[
                                'information_id' =>$info->id,
                                'category_id' =>$catId,
                            ];
                            $challenge = ChallengeCategory::create($ob1);

                        }

                        if($item['parent'] && $challenge && sizeof($item['sub']) > 0){
                            foreach($item['sub'] as $psub){

                                if($psub['subcategory']){

                                    $subcat = Subcategory::firstOrCreate(
                                        ['subcat_name' =>  $psub['subcategory'], 'category_id' =>  $catId],
                                        ['category_id' =>  $catId, 'subcat_name' =>  $psub['subcategory']],
                                    );
                                    $subcatId = $subcat->id;

                                    $chall_subcat_ob =[
                                        'information_id' =>$info->id,
                                        'subcategory_id' => $subcatId,
                                        "challenge_category_id" => $challenge->id
                                    ];

                                    $createSub = ChallengSubcategory::create($chall_subcat_ob);

                                    if($createSub && $psub['sub_subcategory']){

                                            $sub_subcat = SubSubcategory::firstOrCreate(
                                                ['sub_subcat_name' =>  $psub['sub_subcategory']],
                                                ['subcategory_id' =>  $subcatId,'category_id' =>  $catId, 'sub_subcat_name' =>  $psub['sub_subcategory']],
                                            );
                                            $sub_subcatId = $sub_subcat->id;


                                            $info->subSubcategories()->attach($sub_subcatId, ["challenge_category_id" => $challenge->id, "challenge_subcategory_id" => $createSub->id]);

                                    }
                                }
                            }
                        }


                    }



            }


        }


    }

    // public function chunkSize(): int
    // {
    //     return 500;
    // }

    public function onError(\Throwable $e)
    {
        // Handle the exception how you'd like.
    }

    public function onFailure(Failure ...$failure)
    {
    }
}

