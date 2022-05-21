<?php

namespace App\Http\Controllers\Exel;
ini_set('max_execution_time', 360000000000); //3 minutes
ini_set('memory_limit', '-1');
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChallengeCategory;
use App\Models\ChallengSubcategory;
use App\Models\FileUpload;
use App\Models\Information;
use App\Models\Subcategory;
use App\Models\SubSubcategory;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
// use Maatwebsite\Excel\Facades\Excel;
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Reader\Exception;
// use PhpOffice\PhpSpreadsheet\Writer\Xls;
// use PhpOffice\PhpSpreadsheet\IOFactory;


class ExelController extends Controller
{

    // private $exelService;
    // public function __construct(ExelService $exelService)
    // {
    //     $this->exelService = $exelService;
    // }

    // public function testExel(Request $request){

    //     ini_set('memory_limit',-1);
    //     $start_time = Carbon::now();

        //  $the_file = $request->file('info')->store('import');
        //  $the_file = public_path() .'/import/exel.xlsx';

        // $fileName = time().'.'.$request->file('info')->extension();

        // $request->file('info')->move(public_path('import'), $fileName);
        // $the_file = public_path() .'/import/'.$fileName;

    //        $spreadsheet = IOFactory::load($the_file);
    //        $sheet        = $spreadsheet->getActiveSheet();
    //        $row_limit    = $sheet->getHighestDataRow();
    //        return $row_limit;
    //        $column_limit = $sheet->getHighestDataColumn();
    //        $row_range    = range( 2, $row_limit );
    //        $column_range = range( 'F', $column_limit );
    //        $startcount = 2;
    //        return $row_range[0];
    //     //    $data = array();
    //     //    foreach ( $row_range as $row ) {

    //     //         // if($startcount < 501){
    //     //             $data = [
    //     //                 'action' => $sheet->getCell( 'B' . $row )->getValue(),
    //     //                 'challenge' => $sheet->getCell( 'C' . $row )->getValue(),
    //     //                 'address' => $sheet->getCell( 'D' . $row )->getValue(),
    //     //                 'phone' => $sheet->getCell( 'E' . $row )->getValue(),
    //     //                 'food_type' =>$sheet->getCell( 'F' . $row )->getValue(),
    //     //             ];
    //     //             $startcount++;
    //     //         // }
    //     //         DB::table('information')->insert($data);
    //     //    }
    // //    return $sheet->getCell( 'b' . $row_range[0] )->getValue();
    //    $end_time = Carbon::now();
    //    return [$start_time, $end_time];
    //     //    return $data;

    // }


    // public function testlaravelExel(Request $request){

    //     ini_set('memory_limit',-1);

    //     $collection = LazyCollection::make(function () {
    //         // $fileName = time().'.'.$request->file('info')->extension();

    //         // $request->file('info')->move(public_path('import'), $fileName);
    //         $the_file = public_path() .'/import/1644641736.xlsx';
    //         $handle = fopen($the_file, 'r');
    //         while ($line = $handle) {
    //             yield $line;
    //         }
    //     });
    //         foreach($collection as $c){
    //             return $c;
    //         }
    //         // ->chunk(10000)
    //         // ->map(function ($line){
    //         //     return $line;
    //         // })->all();
    //         // ->each(function ($lines) {

    //         //     $list = [];
    //         //     return $lines;
    //         //     foreach ($lines as $line) {
    //         //         if (isset($line[1])) {
    //         //             $list = [
    //         //                 'name' => $line[1],
    //         //             ];

    //         //             return $list;
    //         //         }
    //         //     }
    //         //     return $list;
    //         //     // insert 10000 rows in one shot
    //         //     // Project::insert($list);

    //         // });

    //     //  return  number_format(memory_get_peak_usage() / 1048576, 2) . ' MB';

    // }

    public function uploadExcelFile(){

        $file = FileUpload::where('status', '=','COMPLETED')->first();
        if($file && $file->file_name && file_exists($file->file_name)){
            unlink($file->file_name);
            FileUpload::where('id', $file->id)->delete();
        }

        $check = FileUpload::where('status', '=','PROCESSING')->first();
        if($check){
            return 1;
        }
        $check = FileUpload::where('status','PENDING')->first();
        if(!$check) return;
        $the_file =  $check['file_name'];

        FileUpload::where('id', $check['id'])->update(['status'=>'PROCESSING']);


        \Log::info('Starting');

        $rows = SimpleExcelReader::create($the_file)->getRows()
        ->each(function($row) {
            if($row['AGE RESTRICTED'] || $row['ACTION'] || $row['CHALLENGE NAME']){
                $info = Information::create([
                    'age_restricted' => $row['AGE RESTRICTED'],
                    'action' => $row['ACTION'],
                    'challenge' => $row['CHALLENGE NAME'],
                    'address' => $row['ADDRESS'],
                    'phone' => $row['PHONE NUMBER'],
                    'food_type' => $row['TYPE OF FOOD'],
                    'description' => $row['DESCRIPTION'],
                    'website' => $row['WEBSITE'],
                    'star_rating' => $row['STAR RATING'],
                    'google_ratings' => $row['GOOGLE RATING'],
                    'business_name' => $row['BUSINESS NAME'],
                    'city' => $row['CITY'],
                    'state' => $row['STATE'],
                    'zip_code' => $row['ZIP CODE'],
                    'country' => $row['COUNTRY'],
                    'start_date' => isset($row['EVENT START DATE']) && $row['EVENT START DATE'] ? date('Y-m-d', strtotime($row['EVENT START DATE'])) :null,
                    'end_date' => isset($row['EVENT END DATE']) && $row['EVENT END DATE'] ? date('Y-m-d', strtotime($row['EVENT END DATE'])) :null,
                    'geo_tag' => $row['GEO TAG'],
                    'geo_link' => $row['GEO LINK'],
                    'length' => $row['LENGTH'],
                    'elevation_gain' => $row['ELEVATION GAIN'],
                    'main_pic' => $row['MAIN PICTURE'],
                    'social_media' => $row['SOCIAL MEDIA'],
                    'main_video' => $row['MAIN VIDEO'],
                    'badge_award_one' => $row['BADGE AWARDED 1'],
                    'badge_award_two' => $row['BADGE AWARDED 2'],
                    'badge_award_three' => $row['BADGE AWARDED 3'],
                    'badge_award_four' => $row['BADGE AWARDED 4'],
                    'badge_award_five' => $row['BADGE AWARDED 5'],
                    'state_ranking_elevation' => $row['STATE RANKING ELEVATION'],
                    'state_ranking_prominence' => $row['STATE RANKING PROMINENCE'],
                    'usa_ranking_elevation' => $row['USA RANKING ELEVATION'],
                    'usa_ranking_prominence' => $row['USA RANKING PROMINENCE'],
                    'world_ranking_elevation' => $row['WORLD RANKING ELEVATION'],
                    'facebook_link' => $row['FACEBOOK LINK'],
                    'secondary_video' => $row['SECONDARY VIDEO'],
                    'instagram_link' => $row['INSTAGRAM LINK'],
                    'difficult_level' => $row['DIFFICULT LEVEL'],
                    'picture_two' => $row['PICTURE 2'],
                    'picture_three' => $row['PICTURE 3'],
                    'tower_height' => $row['TOWER HEIGHT'],
                    'focal_point' => $row['FOCAL POINT']
                ]);

                $type = $row['TYPE'];
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
                    'parent' =>$row['PARENT 1'],
                    'sub' =>[
                        [
                            'subcategory'=>$row['SUB1-1'],
                            'sub_subcategory'=>$row['SUB1-1-1'],
                        ],
                        [
                            'subcategory'=>$row['SUB1-2'],
                            'sub_subcategory'=>$row['SUB1-2-1'],
                        ],
                    ],

                ];
                $parentCat2 = [
                    'parent' =>$row['PARENT 2'],
                    'sub' =>[
                        [
                            'subcategory'=>$row['SUB2-1'],
                            'sub_subcategory'=>$row['SUB2-1-1'],
                        ],
                        [
                            'subcategory'=>$row['SUB2-2'],
                            'sub_subcategory'=>$row['SUB2-2-1'],
                        ],
                    ],

                ];

                $parentCat3 = [
                    'parent' =>$row['PARENT 3'],
                    'sub' => [
                        [
                            'subcategory'=>$row['SUB3-1'],
                            'sub_subcategory'=>$row['SUB3-1-1'],
                        ],
                        [
                            'subcategory'=>$row['SUB3-2'],
                            'sub_subcategory'=>$row['SUB3-2-1'],
                        ],
                    ],

                ];
                $parentCat4 = [
                    'parent' =>$row['PARENT 4'],
                    'sub' =>[
                        [
                            'subcategory'=>$row['SUB4-1'],
                            'sub_subcategory'=>$row['SUB4-1-1'],
                        ],
                        [
                            'subcategory'=>$row['SUB4-2'],
                            'sub_subcategory'=>$row['SUB4-2-1'],
                        ],
                    ],

                ];
                $parentCat5 = [
                    'parent' =>$row['PARENT 5'],
                    'sub'=> [
                        [
                            'subcategory'=>$row['SUB5-1'],
                            'sub_subcategory'=>$row['SUB4-1-1'],
                        ],
                        [
                            'subcategory'=>$row['SUB5-2'],
                            'sub_subcategory'=>$row['SUB5-2-1'],
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
        });
        \Log::info('Ending');
        FileUpload::where('id', $check['id'])->update(['status'=>'COMPLETED']);


        return "Success";

        // return [number_format(memory_get_peak_usage() / 1048576, 2) . ' MB', sizeof($rows)];


    }

    public function testSimpleExel(Request $request){

        $fileName = time().'.'.$request->file('info')->extension();

        $request->file('info')->move(public_path('import'), $fileName);
        $the_file = public_path() .'/import/'.$fileName;

        return FileUpload::create(['file_name'=>$the_file]);

    }


    public function db_backup(){
      Artisan::call('backup:run');
      return $this->show_backup();
    }

    public function show_backup(){
        $filePath = storage_path('app/Laravel/');
        $fileNameArray = preg_grep("~\.(zip)$~", scandir($filePath));
        $fileNameArray = implode(",", $fileNameArray);
        $files = explode(",", $fileNameArray);

        $arr = [];
        foreach($files as $f){
            if($f){
              $arr[] =[
                'file' => $f,
              ];
            }

        }

        usort($arr,function($first,$second){
            return $first['file'] < $second['file'];
        });

        return $arr;



    }


    public function download_backup(Request $request){
        $data = $request->all();
        $path = storage_path(). '/app/Laravel/'.$data['file'];
        if(file_exists($path)){
            return response()->download($path);
        }else{
            return response()->json([
                'message' => "Backup file doesn't exist",
            ],401);
        }

    }

    public function deleteBackup(Request $request){
        $data = $request->all();
        $path = storage_path(). '/app/Laravel/'.$data['file'];
        if(file_exists($path)){
            unlink($path);
        }else{
            return response()->json([
                'message' => "Backup file doesn't exist",
            ],401);
        }
    }

}
