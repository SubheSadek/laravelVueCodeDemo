<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Imports\InfoImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Support\Facades\Artisan;

class CategoryController extends Controller
{

    private $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function editAdminUser(Request $request){
        $data = $request->all();
        return $this->categoryService->editAdminUser($data);
   }
   public function getstath(Request $request){
    // $data = $request->all();
    return $this->categoryService->getstath();
}


   public function editAdminPassword(Request $request){
        $data = $request->all();
        return $this->categoryService->updatePassword($data);
    }


    //================================ Category-Start ========================================

    public function addCategory(Request $request){
        $data = $request->all();

        $validator = Validator::make($data,[
            'cat_name'   => 'required|string|unique:categories,cat_name'
        ],[
            'cat_name.required' => "Category name is required.",
            'cat_name.unique' => "Category name must be unique.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->addCategory($data);
    }


    public function editCategory(Request $request){
        $data = $request->all();
        $id = $data['cat_id'] ?? 0;
        $validator = Validator::make($data,[
            'cat_name'   => "required|string|unique:categories,cat_name,$id",
        ],[
            'cat_name.required' => "Category name is required.",
            'cat_name.unique' => "Category name must be unique.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->editCategory($data);
    }

    public function deleteCategory(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'cat_id'   => "required|exists:categories,id",
        ],[
            'cat_id.required' => "Category name is required.",
            'cat_id.exists' => "Category doesn't exists.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->deleteCategory($data);
    }

    public function getAllCategories(Request $request){
        $data = $request->all();
        return $this->categoryService->getAllCategories($data);
    }

    //================================ Category-End ========================================


    //================================ Subcategory-Start ========================================
    public function addSubcategory(Request $request){
        $data = $request->all();

        $validator = Validator::make($data,[
            'category_id'   => 'required|exists:categories,id',
            'subcat_name'   => 'required|string|max:199',
        ],[
            'category_id.required' => "Category is required.",
            'category_id.exists' => "Category doesn't exists.",
            'subcat_name.required' => "Subcategory name is required.",
            'subcat_name.unique' => "Subcategory name must be unique.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->addSubcategory($data);
    }

    public function getAllSubcategories(Request $request){
        $data = $request->all();
        return $this->categoryService->getAllSubcategories($data);
    }

    public function getCategories(){
        return $this->categoryService->getCategories();
    }

    public function editSubcategory(Request $request){
        $data = $request->all();

        $validator = Validator::make($data,[
            'subcat_id'   => "required|exists:subcategories,id",
            'category_id'   => "required|exists:categories,id",
            'subcat_name'   => "required|string|max:199",
        ],[
            'subcat_name.required' => "Subcategory name is required.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->editSubcategory($data);
    }

    public function deletesubcategory(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'subcat_id'   => "required|exists:subcategories,id",
        ],[
            'subcat_id.required' => "Subcategory name is required.",
            'subcat_id.exists' => "Subcategory doesn't exists.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->deletesubcategory($data);
    }

    //================================ Subcategory-End ========================================

    //================================ Sub-Subcategory-Start ========================================
    public function addSubsubcategory(Request $request){
        $data = $request->all();

        $validator = Validator::make($data,[
            'category_id'   => 'required|exists:categories,id',
            'subcategory_id'   => 'required|exists:subcategories,id',
            'sub_subcat_name'   => 'required|string|max:199',
        ],[
            'category_id.required' => "Category is required.",
            'category_id.exists' => "Category doesn't exists.",
            'subcategory_id.required' => "Subcategory is required.",
            'subcategory_id.exists' => "Subcategory doesn't exists.",
            'sub_subcat_name.required' => "Sub-subcategory name is required.",
            'sub_subcat_name.unique' => "Sub-subcategory name must be unique.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }

        return $this->categoryService->addSubsubcategory($data);
    }

    public function getAllSubsubcategories(Request $request){
        $data = $request->all();
        return $this->categoryService->getAllSubsubcategories($data);
    }

    public function getSubcategories(Request $request){
        return $this->categoryService->getSubcategories($request->all());
    }

    public function getSubsubcategories(Request $request){
        return $this->categoryService->getSubsubcategories($request->all());
    }

    public function editSubsubcategory(Request $request){
        $data = $request->all();

        $validator = Validator::make($data,[
            'sub_subcat_id'   => "required|exists:sub_subcategories,id",
            'category_id'   => "required|exists:categories,id",
            'subcategory_id'   => "required|exists:subcategories,id",
            'sub_subcat_name'   => "required|string|max:199",
        ],[
            'sub_subcat_id.required' => "Sub-subcategory is required.",
            'sub_subcat_id.exists' => "Sub-subcategory doesn't exists.",
            'category_id.required' => "Category is required.",
            'category_id.exists' => "Category doesn't exists.",
            'subcategory_id.required' => "Subcategory is required.",
            'subcategory_id.exists' => "Subcategory doesn't exists.",
            'sub_subcat_name.required' => "Sub-subcategory name is required.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->editSubsubcategory($data);
    }

    public function deleteSubsubcategory(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'sub_subcat_id'   => "required|exists:subcategories,id",
        ],[
            'sub_subcat_id.required' => "Sub-subcategory is required.",
            'sub_subcat_id.exists' => "Sub-subcategory doesn't exists.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->deleteSubsubcategory($data);
    }

    //================================ Sub-Subcategory-End ========================================


    //================================ Information-Start ========================================
    public function addInformation(Request $request){
        $data = $request->all();

        $data['start_date'] = $data['start_date'] ? date('Y-m-d', strtotime($data['start_date'])) :null;
        $data['end_date'] = $data['end_date'] ? date('Y-m-d', strtotime($data['end_date'])) :null;

        $validator = Validator::make($data,[
            'identifier'   => 'required|string|unique:information,identifier',
            'action'   => 'required|string|max:199',
            'challenge'   => 'required|string|max:199',
        ],[
            'action.required' => "Info name is required.",
            'challenge.required' => "Challenge is required.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }

        return $this->categoryService->addInformation($data);
    }

    public function editInformation(Request $request){
        $data = $request->all();
        // $data['start_date'] = $data['start_date'] ? date('Y-m-d', strtotime($data['start_date'])) :null;
        // $data['end_date'] = $data['end_date'] ? date('Y-m-d', strtotime($data['end_date'])) :null;

        $validator = Validator::make($data,[
            'info_id'   => 'required|exists:information,id',
            'action'   => 'required|string|max:199',
            'challenge'   => 'required|string|max:199',
        ],[
            'action.required' => "Info name is required.",
            'challenge.required' => "Challenge is required.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }

        return $this->categoryService->editInformation($data);
    }

    public function deleteInformation(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'info_id'   => "required|exists:information,id",
        ],[
            'info_id.required' => "Information is required.",
            'info_id.exists' => "Information doesn't exists.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->deleteInformation($data);
    }

    public function getAllInfo(Request $request){
        $data = $request->all();
        return $this->categoryService->getAllInfo($data);
    }

    public function searchInfo(Request $request){
        $data = $request->all();
        return $this->categoryService->searchInfo($data);
    }

    public function getSingleEditData(Request $request){
        $data = $request->all();
        return $this->categoryService->getSingleEditData_two($data);
        // return $this->categoryService->getSingleEditData($data);
    }

    public function getSingleEditData_two(Request $request){
        $data = $request->all();
        return $this->categoryService->getSingleEditData_two($data);
    }

    public function challengCategory(Request $request){
        $data = $request->all();
        return $this->categoryService->challengCategory($data);
    }
    //================================ Information-End ========================================



    //================================ Admin-Start ========================================
    public function createAdmin(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'first_name'   => 'required|string|max:199',
            'last_name'   => 'required|string|max:199',
            'email' => 'required|string|max:199|unique:users,email',
            'username' => 'required|string|max:199|unique:users,username|regex:/^\S*$/u',
            'password' => 'required|min:6',
            'gender' => 'required|in:MALE,FEMALE,OTHER',
        ],[
            'first_name.required' =>"First Name is required!",
            'last_name.required' =>"Last Name is required!",
            'username.unique' =>"User must be unique!",
            'username.regex' =>"User can not contain blank spaces!",
            'email.unique' =>"Email must be unique!",
            'password.required' =>"Password is required!",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->createAdmin($data);
    }
    public function editAdmin(Request $request){
        $data = $request->all();
        $id = $data['uid'];
        $validator = Validator::make($data,[
            'uid'   => 'required|exists:users,id',
            'first_name'   => 'required|string|max:199',
            'last_name'   => 'required|string|max:199',
            'email' => 'required|string|max:199|unique:users,email,'. $id,
            'username' => 'required|string|max:199|regex:/^\S*$/u|unique:users,username,'. $id,
            'gender' => 'required|in:MALE,FEMALE,OTHER',
        ],[
            'first_name.required' =>"First Name is required!",
            'last_name.required' =>"Last Name is required!",
            'username.unique' =>"Author must be unique!",
            'username.regex' =>"Author can not contain blank spaces!",
            'email.required' =>"Email is required!",
            'email.unique' =>"Email must be unique!",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->editAdmin($data);
    }

    public function getAllAdmins(Request $request){
        $data = $request->all();
        return $this->categoryService->getAllAdmins($data);
    }

    public function deleteAdmin(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'uid'   => "required|exists:users,id",
        ],[
            'uid.required' => "User is required.",
            'uid.exists' => "User doesn't exists.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->deleteAdmin($data);
    }
    //================================ Admin-End ========================================




    //================================ Type-Start ========================================
    public function addType(Request $request){
        $data = $request->all();

        $validator = Validator::make($data,[
            'type_name'   => 'required|string|unique:types,type_name'
        ],[
            'type_name.required' => "Information type is required.",
            'type_name.unique' => "Information type must be unique.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->addType($data);
    }
    public function getAllTypes(Request $request){
        return $this->categoryService->getAllTypes($request->all());
    }
    public function getTypes(Request $request){
        return $this->categoryService->getTypes($request->all());
    }
    public function editType(Request $request){
        $data = $request->all();
        $id = $data['type_id'] ?? 0;
        $validator = Validator::make($data,[
            'type_id'   => "required|exists:types,id",
            'type_name'   => "required|string|unique:types,type_name, $id",
        ],[
            'type_name.required' => "Category name is required.",
            'type_name.unique' => "Category name must be unique.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->editType($data);
    }
    public function deleteType(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'type_id'   => "required|exists:types,id",
        ],[
            'type_id.required' => "Type is required.",
            'type_id.exists' => "Type doesn't exists.",
        ]);

        if($validator->fails()){
            return response()->json([
                'messages' => collect($validator->errors()->all())
            ], 422);
        }
        return $this->categoryService->deleteType($data);
    }
    //================================ Type-End ========================================


    //================================ Import-export-start ========================================
    public function importInfo(Request $request){

        try {

            // $file = $request->file('info');
            $fileName = time().'.'.$request->file('info')->extension();

        $request->file('info')->move(public_path('import'), $fileName);
        $the_file = public_path() .'/import/'.$fileName;
            // return $file;
            $import = new InfoImport;
            $import->onlySheets(0);
            $import->import($the_file);

            if ($import->failures()->isNotEmpty()) {
                return $import->failures();
            }


        } catch (\Exception $e) {
            Bugsnag::notifyException($e);

            throw $e;
        }
    }


    public function deleteAllInfo (Request $request){

         Artisan::call('migrate:fresh', [
            '--force' => true
        ]);

        Artisan::call('db:seed', array('--class' => "DatabaseSeeder",
        '--force' => true));

        return "Information deleted successfully!";

    }

    public function testExel(Request $request){
        $file_path="/import/SAMPLE2A.xlsx";
        // getting excel file data into array


        }
    //================================ Import-export-end ========================================


}
