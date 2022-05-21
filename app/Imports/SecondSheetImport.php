<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class SecondSheetImport implements ToCollection, WithHeadingRow
// , WithChunkReading, ShouldQueue
{

        public function collection(Collection $rows)
        {
            foreach ($rows as $row) {
             $cat_id ='';
              $check = Category::where('cat_name', $row['parent_categories'])->first();
              if($check){
                  $cat_id = $check->id;
              }

              if(!$check){

                    $category = Category::create([
                        'cat_name' => $row['parent_categories'],
                    ]);
                    $cat_id = $category->id;
              }
            //   SUB CATEGORIES

              if($cat_id){

              $check2 = Subcategory::where('subcat_name', $row['sub_categories'])->where('category_id', $cat_id)->count();
                if(!$check2){
                        Subcategory::create([
                            'category_id' => $cat_id,
                            'subcat_name' => $row['sub_categories'],
                        ]);
                    }
              }


            }

        }

        public function chunkSize(): int
        {
            return 1000;
        }

        public function batchSize(): int
        {
            return 1000;
        }

}
