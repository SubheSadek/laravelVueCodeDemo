<?php

namespace App\Imports;

use App\Models\Information;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;
class InfoImport implements WithMultipleSheets, WithHeadingRow, WithChunkReading, ShouldQueue, WithEvents, SkipsOnError, SkipsOnFailure
{
    // WithValidation
    use Importable, WithConditionalSheets, RegistersEventListeners, SkipsErrors, SkipsFailures;

    public function conditionalSheets(): array
    {
        return [
            // 'TAXONOMY CATEGORIES' => new SecondSheetImport(),
            0 => new FirstSheetImport(),
        ];
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public static function afterImport(AfterImport $event)
    {

    }

    public function onFailure(Failure ...$failure)
    {
    }

    public function onError(\Throwable $e)
    {
        // Handle the exception how you'd like.
    }

    // public function rules(): array
    // {
    //     return [
    //         '*.identifier' => ['identifier', 'unique:information,identifier']
    //     ];
    // }

}
