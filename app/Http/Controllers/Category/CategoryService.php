<?php

namespace App\Http\Controllers\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class CategoryService
{
    private $categoryQuery;
    public function __construct(CategoryQuery $categoryQuery)
    {
        $this->categoryQuery = $categoryQuery;
    }

    public function editAdminUser($data){

       $auth = Auth::user();
       if(!$auth || $auth['id'] !=$data['id']){
           return response()->json([
               'message' => "Your are not authorised User!.",
           ],401);
         }
         $user =  $this->categoryQuery->checkUser($auth['id'], $data['email']);

         if($user){
            return response()->json([
                'message' => "Email must be unique!.",
            ],401);
         }

         return $this->categoryQuery->editAdminUser('id',$data['id'], [
           "first_name"=> $data['first_name'],
           "last_name"=> $data['last_name'],
           "username"=> $data['username'],
           "email"=>$data['email']
         ]);

   }

    public function updatePassword($data)
    {
        if( $data['id'] != Auth::id()){
            return response()->json([
              'message' => "You are not Authenticate Admin!",
            ], 401);
         }

         $admin = $this->categoryQuery->getSingleUser('id', $data['id']);
        //  \Log::info($admin);
        //  return $admin['password'] ;

         if($admin){

            $checkOld =Hash::check($data['currentPassword'], $admin->password );
            $checkNew =Hash::check($data['newPassword'], $admin->password );

            if(!$checkOld){
              return response()->json([
                'message' => "Password does not match to our records!",
              ], 401);
            }
            if($checkNew){
              return response()->json([
                'updated' => "Password is already been taken!",
              ], 401);
            }

         }else{

                return response()->json([
                  'message' => "Password does not exists !",
                ], 401);

         }

        return $this->categoryQuery->editAdminUser('id',$data['id'], [
            "password"=>Hash::make($data['newPassword'])
          ]);

    }

    public function getstath(){
        return $this->categoryQuery->getstath();
    }
    //================================ Category-Start ========================================
    public function addCategory($data){
        return $this->categoryQuery->addCategory($data);
    }
    public function editCategory($data){
        return $this->categoryQuery->editCategory($data);
    }
    public function deleteCategory($data){
        return $this->categoryQuery->deleteCategory($data);
    }
    public function getAllCategories($data){
        return $this->categoryQuery->getAllCategories($data);
    }

    //================================ Category-End ========================================

    //================================ Subcategory-Start ========================================
    public function addSubcategory($data){
        return $this->categoryQuery->addSubcategory($data);
    }
    public function getCategories(){
        return $this->categoryQuery->getCategories();
    }
    public function getAllSubcategories($data){
        return $this->categoryQuery->getAllSubcategories($data);
    }
    public function editSubcategory($data){
        return $this->categoryQuery->editSubcategory($data);
    }
    public function deletesubcategory($data){
        return $this->categoryQuery->deletesubcategory($data);
    }
    //================================ Subcategory-End ========================================

    //================================ Sub-Subcategory-Start ========================================
    public function addSubsubcategory($data){
        return $this->categoryQuery->addSubsubcategory($data);
    }
    public function getSubcategories($data){
        return $this->categoryQuery->getSubcategories($data);
    }
    public function getSubsubcategories($data){
        return $this->categoryQuery->getSubsubcategories($data);
    }
    public function getAllSubsubcategories($data){
        return $this->categoryQuery->getAllSubsubcategories($data);
    }
    public function editSubsubcategory($data){
        return $this->categoryQuery->editSubsubcategory($data);
    }
    public function deleteSubsubcategory($data){
        return $this->categoryQuery->deleteSubsubcategory($data);
    }

    //================================ Sub-Subcategory-End ========================================


    //================================ Information-Statt ========================================

    public function addInformation($data){
        return $this->categoryQuery->addInformation($data);
    }
    public function editInformation($data){
        return $this->categoryQuery->editInformation($data);
    }
    public function getAllInfo($data){
        return $this->categoryQuery->getAllInfo($data);
    }
    public function searchInfo($data){
        return $this->categoryQuery->searchInfo($data);
    }
    public function getSingleEditData($data){
        $info = $this->categoryQuery->getSingleEditData($data);
        $arr = array();
        foreach($info->category as $i){

            $ob = [];
            $ob['category_id'] = $i->category_id;
            $ob['subcategory']= array();
            $ob['subcategories']= array();

            foreach($i->challeng_sub as $sub){
                $ob2 =[];
                $ob2['subcategory_id'] = $sub->subcategory_id;
                $ob2['sub_subcategory_id'] = array();
                $ob2['subSubcategories'] = array();

                foreach($sub->sub_subcategories as $sub_sub){
                    array_push($ob2['sub_subcategory_id'], $sub_sub->sub_subcategory_id);
                }

                foreach($sub->subSubcategory as $sub_sub){
                    $subsubOb =[
                        'id' => $sub_sub->id,
                        'sub_subcat_name' => $sub_sub->sub_subcat_name,
                    ];
                    array_push($ob2['subSubcategories'], $subsubOb);
                }

                array_push($ob['subcategory'], $ob2);
            }

            foreach($i->subcategory as $sub){
                $subOb =[
                    'id' => $sub->id,
                    'subcat_name' => $sub->subcat_name,
                ];
                array_push($ob['subcategories'], $subOb);
            }


            array_push($arr, $ob);

        }
        $arr2 = array();
        foreach($info->types as $t){
            array_push($arr2, $t->id);
        }
        $info->parent= $arr;
        $info->type_id = $arr2;
        return $info;

    }
    public function getSingleEditData_two($data){
        $info = $this->categoryQuery->getSingleEditData($data);
        $arr =[];
        if(sizeof($info->category) < 1){
            $arr = [
                [
                    'category_id' => 0,
                    'subcategory' => [
                        [
                            'subcategory_id' => 0,
                            'sub_subcategory_id' =>[],
                            'subSubcategories' =>[],
                        ],
                        [
                            'subcategory_id' => 0,
                            'sub_subcategory_id' =>[],
                            'subSubcategories' =>[],
                        ]
                    ],
                    'subcategories' => [],
                ]
            ];
        }


        foreach($info->category as $i){

            $ob = [];
            $ob['category_id'] = $i->category_id;
            $ob['subcategory']= array();

            if(sizeof($i->challeng_sub) < 1){
                $ob['subcategory']= [
                    [
                        'subcategory_id' => 0,
                        'sub_subcategory_id' =>[],
                        'subSubcategories' =>[],
                    ],
                    [
                        'subcategory_id' => 0,
                        'sub_subcategory_id' =>[],
                        'subSubcategories' =>[],
                    ]
                ];
            }

            if(sizeof($i->challeng_sub) > 0 && sizeof($i->challeng_sub) < 2){
                $ob['subcategory']= [
                    [
                        'subcategory_id' => 0,
                        'sub_subcategory_id' =>[],
                        'subSubcategories' =>[],
                    ]
                ];
            }

            $ob['subcategories']= array();

            foreach($i->challeng_sub as $sub){
                $ob2 =[];
                $ob2['subcategory_id'] = $sub->subcategory_id;
                $ob2['sub_subcategory_id'] = array();
                $ob2['subSubcategories'] = array();

                foreach($sub->sub_subcategories as $sub_sub){
                    array_push($ob2['sub_subcategory_id'], $sub_sub->sub_subcategory_id);
                }

                foreach($sub->subSubcategory as $sub_sub){
                    $subsubOb =[
                        'id' => $sub_sub->id,
                        'sub_subcat_name' => $sub_sub->sub_subcat_name,
                    ];
                    array_push($ob2['subSubcategories'], $subsubOb);
                }

                array_unshift($ob['subcategory'], $ob2);
            }

            foreach($i->subcategory as $sub){
                $subOb =[
                    'id' => $sub->id,
                    'subcat_name' => $sub->subcat_name,
                ];
                array_push($ob['subcategories'], $subOb);
            }


            array_push($arr, $ob);

        }
        $arr2 = array();
        foreach($info->types as $t){
            array_push($arr2, $t->id);
        }
        $info->parent= $arr;
        $info->type_id = $arr2;
        return $info;

    }
    public function challengCategory($data){
        $cat = $this->categoryQuery->challengCategory($data);
        // return $cat;
        $ob = [];
        if($cat){
            $ob['cat_name'] = $cat->cat ? $cat->cat->cat_name: null;
            $ob['subcategory'] = array();
            // $ob['sub_subcategory'] = array();

            foreach($cat->challeng_sub as $sub){
                $subObj = [];
                $subObj['subcat_name'] = $sub->subcategory->subcat_name;
                $subObj['sub_subcategory'] = array();
                // $subOb = [
                //     "subcat_name" => $sub->subcategory? $sub->subcategory->subcat_name: null,
                // ];

                //

                foreach($sub->sub_subcategories as $sub2){
                    $sub_subOb = [
                        "sub_subcat_name" => $sub2->sub_subcategory? $sub2->sub_subcategory->sub_subcat_name: null,
                    ];

                    array_push($subObj['sub_subcategory'], $sub_subOb);
                }

                array_push($ob['subcategory'], $subObj);
            }

        }

        return $ob;
    }
    public function deleteInformation($data){
        return $this->categoryQuery->deleteInformation($data);
    }
    //================================ Information-End ========================================


    //================================ Admin-Start ========================================
    public function createAdmin($data){
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'ADMIN';
        $data['status'] = 'ACTIVE';
        return $this->categoryQuery->createAdmin($data);
    }
    public function editAdmin($data){
        if(isset($data['password']) && strlen($data['password']) <6){
            return response()->json([
                'message' => "Password must be at least 6 characters long!",
            ],401);
        }else if(isset($data['password']) && strlen($data['password']) >5){
            $data['password'] = Hash::make($data['password']);
        }

        return $this->categoryQuery->editAdmin($data);
    }
    public function getAllAdmins($data){
        return $this->categoryQuery->getAllAdmins($data);
    }
    public function deleteAdmin($data){
        return $this->categoryQuery->deleteAdmin($data);
    }
    //================================ Admin-End ========================================


    //================================ Type-Start ========================================
    public function addType($data){
        return $this->categoryQuery->addType($data);
    }
    public function getAllTypes($data){
        return $this->categoryQuery->getAllTypes($data);
    }
    public function getTypes($data){
        return $this->categoryQuery->getTypes($data);
    }
    public function editType($data){
        return $this->categoryQuery->editType($data);
    }
    public function deleteType($data){
        return $this->categoryQuery->deleteType($data);
    }
    //================================ Type-End ========================================


    //================================ import-export-start ========================================

    //================================ import-export-start ========================================

}
