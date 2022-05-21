<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use App\Models\ChallengeCategory;
use App\Models\ChallengeSubsubcategory;
use App\Models\ChallengSubcategory;
use App\Models\Information;
use App\Models\Subcategory;
use App\Models\SubSubcategory;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class CategoryQuery
{
    public function  getstath()
    {
        $cat = Category::count('id');
        $subcat = Subcategory::count('id');
        $subsubcat = SubSubcategory::count('id');
        $items = Information::count('id');
        return [
            "cat"=>$cat,
            "subcat"=>$subcat,
            "subsubcat"=>$subsubcat,
            "items"=>$items,
        ];
        // return User::where('id','!=',$id)->where('email',$email)->first();
    }

    public function checkUser($id,$email)
    {
        return User::where('id','!=',$id)->where('email',$email)->first();
    }

    public function editAdminUser($key, $value, $user){
        return User::where($key, $value)->update($user);
    }
    public function getSingleUser($key, $value){
        return User::where($key, $value)->first();
      }
    //================================ Category-Start ========================================
    public function addCategory($data){
        return Category::create($data);
    }
    public function editCategory($data){
        $id = $data["cat_id"] ?? 0;
        unset($data["cat_id"]);
        return Category::where('id', $id)->update($data);
    }
    public function deleteCategory($data){
        $id = $data["cat_id"] ?? 0;
        return Category::where('id', $id)->delete();
    }
    public function getAllCategories($data){
        $str = $data["str"] ?? null;
        $str = "%".$str."%";
        $perPage = $data["perPage"] ?? 10;

        return Category::when($str, function($q) use($str){
            $q->where('cat_name', 'like', $str);
        })->orderByDesc('id')->paginate($perPage);
    }

    //================================ Category-End ========================================

    //================================ Subcategory-Start ========================================
    public function addSubcategory($data){
        $subcat = Subcategory::create($data);
        if($subcat){
            return Subcategory::where('id', $subcat->id)->with('category')->first();
        }
    }

    public function getCategories(){
        return Category::select('id','cat_name')->get();
    }
    public function getAllSubcategories($data){
        $str = $data["str"] ?? null;
        $str = "%".$str."%";
        $perPage = $data["perPage"] ?? 10;
        return Subcategory::when($str, function($q) use($str){
            $q->where('subcat_name', 'like', $str);
            $q->orWhereHas('category', function (Builder $query) use($str) {
                $query->where('cat_name', 'like', $str);
            });
        })->with('category:id,cat_name')->orderByDesc('id')->paginate($perPage);
    }
    public function editSubcategory($data){
        $id = $data["subcat_id"] ?? 0;
        unset($data["subcat_id"]);
        $subcat = Subcategory::where('id', $id)->update($data);
        if($subcat){
            return Subcategory::where('id', $id)->with('category')->first();
        }
    }
    public function deletesubcategory($data){
        $id = $data["subcat_id"] ?? 0;
        return Subcategory::where('id', $id)->delete();
    }

    //================================ Subcategory-End ========================================

    //================================ Subcategory-Start ========================================
    public function addSubsubcategory($data){

        $subcat = SubSubcategory::create($data);
        if($subcat){
            return SubSubcategory::where('id', $subcat->id)->with('category')->with('subcategory')->first();
        }

    }
    public function getSubcategories($data){
        $cat_id = $data['cat_id'] ?? 0;
        return Subcategory::when($cat_id, function($q) use($cat_id){
            $q->where('category_id', $cat_id);
          })->select('id','subcat_name')->get();
    }
    public function getSubsubcategories($data){
        $id = $data['subcat_id'] ?? 0;
        return SubSubcategory::when($id, function($q) use($id){
            $q->where('subcategory_id', $id);
          })->select('id','sub_subcat_name')->get();
    }
    public function getAllSubsubcategories($data){
        $str = $data["str"] ?? null;
        $str = "%".$str."%";
        $perPage = $data["perPage"] ?? 10;
        return SubSubcategory::when($str, function($q) use($str){
            $q->where('sub_subcat_name', 'like', $str);
            $q->orWhereHas('category', function (Builder $query) use($str) {
                $query->where('cat_name', 'like', $str);
            });
            $q->orWhereHas('subcategory', function (Builder $query) use($str) {
                $query->where('subcat_name', 'like', $str);
            });
        })->with('category:id,cat_name')->with('subcategory:id,subcat_name')->orderByDesc('id')->paginate($perPage);
    }
    public function editSubsubcategory($data){
        $id = $data["sub_subcat_id"] ?? 0;
        unset($data["sub_subcat_id"]);
        $subcat = SubSubcategory::where('id', $id)->update($data);
        if($subcat){
            return SubSubcategory::where('id', $id)->with('category')->with('subcategory')->first();
        }
    }

    public function deleteSubsubcategory($data){
        $id = $data["sub_subcat_id"] ?? 0;
        return SubSubcategory::where('id', $id)->delete();
    }


    //================================ Subcategory-End ========================================


    //================================ Information-Start ========================================

    public function addInformation($data){
        $tId = $data['type_id'] && sizeof($data['type_id']) > 0 ? $data['type_id'] : null;
        unset($data['type_id']);
        $info = Information::create($data);

        if($tId){
            $info->types()->attach($tId);
        }

        foreach($data['parent'] as $p){
            if(isset($p["category_id"]) && $p["category_id"]){
                $ob = [
                    "information_id" => $info->id,
                    "category_id" =>$p["category_id"],
                ];
                $cat = ChallengeCategory::create($ob);


                if($cat && ( sizeof($p['subcategory']) > 0)){
                    foreach($p['subcategory'] as $sub){

                    if($sub['subcategory_id']){
                            $subOb = [
                                "information_id" => $info->id,
                                'subcategory_id'=> $sub['subcategory_id'],
                                'challenge_category_id'=>$cat->id,
                            ];
                            $chall_subcat = ChallengSubcategory::create($subOb);

                            if($chall_subcat && $sub['sub_subcategory_id']){
                                $info->subSubcategories()->attach($sub['sub_subcategory_id'], ["challenge_subcategory_id" => $chall_subcat->id ,"challenge_category_id" => $cat->id]);
                            }
                    }


                    }
                }
            }
        }
        return $info;
    }

    public function editInformation($data){
        // return $data;
        $id = $data['info_id'];
        $category_id =$data['category_id'] ?? null;
        $subcategory_id =$data['subcategory_id'] ?? null;
        $sub_subcategory_id =$data['sub_subcategory_id'] ?? null;
        $tId = $data['type_id'] ?? 0;

        unset($data['info_id'],$data['category_id'],$data['subcategory_id'],$data['sub_subcategory_id'], $data['type_id']);

        $info = Information::where('id', $id)->first();
        $info->update($data);

        if($tId){
            $info->types()->syncWithPivotValues($tId, []);
        }
        ChallengeCategory::where('information_id', $id)->delete();

        if(isset($data['parent']) && sizeof($data['parent']) > 0){
            foreach($data['parent'] as $p){

                if(isset($p["category_id"]) && $p["category_id"]){
                    $ob = [
                        "information_id" => $info->id,
                        "category_id" =>$p["category_id"],
                    ];

                    $cat = ChallengeCategory::create($ob);

                    if($cat && ( isset($p['subcategory']) && sizeof($p['subcategory']) > 0)){
                        foreach($p['subcategory'] as $sub){

                            if($sub['subcategory_id']){
                                    $subOb = [
                                        "information_id" => $info->id,
                                        'subcategory_id'=> $sub['subcategory_id'],
                                        'challenge_category_id'=>$cat->id,
                                    ];
                                    $chall_subcat = ChallengSubcategory::create($subOb);

                                    if($chall_subcat && isset($sub['sub_subcategory_id']) && sizeof($sub['sub_subcategory_id']) > 0){
                                        foreach($sub['sub_subcategory_id'] as $sub3){

                                            if($sub3){
                                                $obSub3 =[
                                                    'sub_subcategory_id' => $sub3,
                                                    'challenge_subcategory_id' => $chall_subcat->id,
                                                    'challenge_category_id' => $cat->id,
                                                    'information_id' => $info->id
                                                ];
                                                ChallengeSubsubcategory::create($obSub3);
                                            }

                                        }

                                        // $info->subSubcategories()->syncWithPivotValues($sub['sub_subcategory_id'], ["challenge_subcategory_id" => $chall_subcat->id ,"challenge_category_id" => $cat->id]);
                                    }
                            }


                        }
                    }
                }


            }
        }


        return $info;
    }

    public function deleteInformation($data){
        $id = $data["info_id"] ?? 0;
        return Information::where('id', $id)->delete();
    }

    public function getAllInfo($data){
        $str = $data["str"] ?? null;
        $str = "%".$str."%";
        $perPage = $data["perPage"] ?? 10;

        return Information::when($str, function($q) use($str){
            $q->where(function($q2) use ($str){
                $q2->where('action', 'like', $str );
                $q2->orWhere('challenge', 'like', $str );
                $q2->orWhere('address', 'like', $str );
                $q2->orWhere('phone', 'like', $str );
                $q2->orWhere('food_type', 'like', $str );
                $q2->orWhere('description', 'like', $str );
                $q2->orWhere('website', 'like', $str );
                $q2->orWhere('star_rating', 'like', $str );
                $q2->orWhere('google_ratings', 'like', $str );
                $q2->orWhere('age_restricted', 'like', $str );
                $q2->orWhere('business_name', 'like', $str );
                $q2->orWhere('city', 'like', $str );
                $q2->orWhere('state', 'like', $str );
                $q2->orWhere('country', 'like', $str );
                $q2->orWhere('zip_code', 'like', $str );
                $q2->orWhere('start_date', 'like', $str );
                $q2->orWhere('end_date', 'like', $str );
                $q2->orWhere('geo_tag', 'like', $str );
                $q2->orWhere('geo_link', 'like', $str );
            });
            $q->orWhereHas('categories', function (Builder $query) use($str) {
                $query->where('cat_name', 'like', $str);
            });
            $q->orWhereHas('subcategories', function (Builder $query) use($str) {
                $query->where('subcat_name', 'like', $str);
            });
            $q->orWhereHas('subSubcategories', function (Builder $query) use($str) {
                $query->where('sub_subcat_name', 'like', $str);
            });
        })->with('category.cat')->orderByDesc('id')->paginate($perPage);
    }

    public function searchInfo($data){
        $str = isset($data["str"]) && $data["str"] ? $data["str"]."%" : null;
        $limit = $data["limit"] ?? 10;
        $lastId = $data["lastId"] ?? null;

        return Information::when($str, function($q) use($str){
            $q->where(function($q2) use ($str){
                $q2->where('action', 'like', $str );
                $q2->orWhere('challenge', 'like', $str );
                // $q2->orWhere('address', 'like', $str );
                // $q2->orWhere('phone', 'like', $str );
                // $q2->orWhere('food_type', 'like', $str );
                // $q2->orWhere('description', 'like', $str );
                // $q2->orWhere('website', 'like', $str );
                // $q2->orWhere('star_rating', 'like', $str );
                // $q2->orWhere('google_ratings', 'like', $str );
                // $q2->orWhere('age_restricted', 'like', $str );
                // $q2->orWhere('business_name', 'like', $str );
                // $q2->orWhere('city', 'like', $str );
                // $q2->orWhere('state', 'like', $str );
                // $q2->orWhere('country', 'like', $str );
                // $q2->orWhere('zip_code', 'like', $str );
                // $q2->orWhere('start_date', 'like', $str );
                // $q2->orWhere('end_date', 'like', $str );
                // $q2->orWhere('geo_tag', 'like', $str );
                // $q2->orWhere('geo_link', 'like', $str );
            });
            // $q->orWhereHas('categories', function (Builder $query) use($str) {
            //     $query->where('cat_name', 'like', $str);
            // });
            // $q->orWhereHas('subcategories', function (Builder $query) use($str) {
            //     $query->where('subcat_name', 'like', $str);
            // });
            // $q->orWhereHas('subSubcategories', function (Builder $query) use($str) {
            //     $query->where('sub_subcat_name', 'like', $str);
            // });
        })->when($lastId, function($q) use($lastId){
            $q->where('id', '<', $lastId);
        })->with('category.cat')->orderByDesc('id')->limit($limit)->get();
    }

    public function getSingleEditData($data){
        $id = $data['info_id'] ?? 0;
        $info = Information::when($id, function($q)use($id){
            $q->where('id', $id);
        })
        ->with(['category' =>function($q){
            $q->with('cat:id,cat_name');
            $q->with(['challeng_sub'=>function($q2){
                $q2->with('subcategory:id,subcat_name');
                $q2->with('sub_subcategories');
                $q2->with("subSubcategory");
            }]);

            $q->with('subcategory');

        }])->with('types')
        ->first();
        return $info;
    }

    public function challengCategory($data){
        $id = $data['id'] ?? 0;
        return ChallengeCategory::when($id, function($q) use ($id){
            $q->where('id', $id);
        })->with('cat')->with(['challeng_sub' =>function($q){
            $q->with('subcategory');
            $q->with('sub_subcategories.sub_subcategory');
        }])->first();

    }

    //================================ Information-End ========================================


    //================================ Admin-start ========================================
    public function createAdmin($data){
        return User::create($data);
    }
    public function editAdmin($data){
        $uid = $data['uid'] ?? 0 ;
        unset($data['uid']);
        return User::where('id', $uid)->update($data);
    }
    public function getAllAdmins($data){
        $str = $data["str"] ?? null;
        $str = "%".$str."%";
        $perPage = $data["perPage"] ?? 10;
        return User::when($str, function($q) use($str){
            $q->whereRaw("concat(
                first_name,
                ' ', last_name,
                ' ', email,
                ' ', username,
                ' ', gender
                ) like '$str' ");
        })->where('role', '!=', 'SUPER_ADMIN')->orderByDesc('id')->paginate($perPage);
    }
    public function deleteAdmin($data){
        $id = $data["uid"] ?? 0;
        return User::where('id', $id)->delete();
    }
    //================================ Admin-End ========================================


    //================================ Type-Start ========================================
    public function addType($data){
        return Type::create($data);
    }
    public function getAllTypes($data){
        $str = $data["str"] ?? null;
        $str = "%".$str."%";
        $perPage = $data["perPage"] ?? 10;

        return Type::when($str, function($q) use($str){
            $q->where('type_name', 'like', $str);
        })->orderByDesc('id')->paginate($perPage);
    }
    public function getTypes($data){
        return Type::orderByDesc('id')->get();
    }
    public function editType($data){
        $id = $data["type_id"] ?? 0;
        unset($data["type_id"]);
        return Type::where('id', $id)->update($data);
    }
    public function deleteType($data){
        $id = $data["type_id"] ?? 0;
        return Type::where('id', $id)->delete();
    }
    //================================ Type-End ========================================

    //================================ import-export-Start ========================================

    //================================ import-export-Start ========================================

}
